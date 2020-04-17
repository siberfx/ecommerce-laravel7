<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CategoryCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;
    use ReorderOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Category');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/categories');
        $this->crud->setEntityNameStrings('Category', 'Categories');

        $this->crud->addColumns(
            $this->getColumns()
        );
        $this->crud->addFields(
            $this->getFields()
        );

    }

    protected function setupReorderOperation()
    {
        // define which model attribute will be shown on draggable elements
        $this->crud->set('reorder.label', 'name');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 2);
    }

    protected function setupListOperation()
    {
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(CategoryRequest::class);
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setValidation(CategoryRequest::class);

    }

    /**
     * @return array
     */
    private function getColumns()
    {
        return [
            [
                'type'      => "select",
                'label'     => __('category.parent'),
                'name'      => 'parent_id',
                'entity'    => 'parent',
                'attribute' => "name",
                'model'     => "App\Models\Category",
            ],
            [
                'name'  => 'name',
                'label' => __('category.name'),
            ],
            [
                'name'  => 'slug',
                'label' => __('category.slug'),
            ]
        ];
    }

    /**
     * @return array
     */
    private function getFields()
    {
        return [
            [
                'label' => __('category.parent'),
                'type' => 'select_from_array',
                'options' => Category::pluck('name', 'id'),
                'name' => 'parent_id',
                'allows_null' => true,
            ],
            [
                'name'  => 'name',
                'label' => __('category.name'),
                'type'  => 'text',
            ],
            [
                'name'  => 'slug',
                'label' => __('category.slug'),
                'type'  => 'text',
            ]
        ];
    }
}

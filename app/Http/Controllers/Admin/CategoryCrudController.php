<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
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
                'model'     => Category::class,
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

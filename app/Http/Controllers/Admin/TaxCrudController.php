<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TaxRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TaxCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TaxCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Tax');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/taxes');
        $this->crud->setEntityNameStrings('tax', 'taxes');

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
        $this->crud->setValidation(TaxRequest::class);
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setValidation(TaxRequest::class);

    }

    /**
     * @return array
     */
    private function getColumns()
    {
        return [
            [
                'name'  => 'name',
                'label' => __('tax.name'),
            ],
            [
                'name'  => 'value',
                'label' => __('tax.value'),
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
                'label' => __('tax.name'),
                'type'  => 'text',
            ],
            [
                'name'  => 'value',
                'label' => __('tax.value'),
                'hint'  => __('tax.hint_value'),
                'type'  => 'text',
            ]
        ];
    }
}

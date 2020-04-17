<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CarrierRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CarrierCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CarrierCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Carrier');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/carriers');
        $this->crud->setEntityNameStrings('carrier', 'carriers');

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
        $this->crud->setValidation(CarrierRequest::class);
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setValidation(CarrierRequest::class);

    }

    /**
     * @return array
     */
    private function getColumns()
    {
        return [
            [
                'name'  => 'name',
                'label' => trans('category.name'),
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
                'label' => trans('carrier.name'),
                'type'  => 'text',
            ],
            [
                'name'       => 'price',
                'label'      => trans('carrier.price'),
                'type'       => 'number',
                'attributes' => [
                    'step' => 'any'
                ]
            ],
            [
                'name'  => 'delivery_text',
                'label' => trans('carrier.delivery_text'),
                'type'  => 'text',
            ],
            [
                'name'    => "logo",
                'label'   => trans('carrier.logo'),
                'type'    => 'image',
                'upload'  => true,
                'crop'    => false,
                'default' => 'default.png',
                'prefix'  => 'uploads/carriers/'
            ]
        ];
    }
}

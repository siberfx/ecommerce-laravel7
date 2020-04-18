<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderStatusRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class OrderStatusCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class OrderStatusCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\OrderStatus');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/order-statuses');
        $this->crud->setEntityNameStrings('order status', 'order statuses');

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
        $this->crud->setValidation(OrderStatusRequest::class);
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setValidation(OrderStatusRequest::class);

    }

    /**
     * @return array
     */
    private function getColumns()
    {
        return [
            [
                'name'  => 'name',
                'label' => __('order.status_name'),
            ],
            [
                'name'  => 'notification',
                'label' => __('order.notification'),
                'type'  => 'boolean',
                'options' => [0 => 'Disabled', 1 => 'Enabled']
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
                'label' => __('order.status_name'),
                'type'  => 'text',
            ],
            [
                'name'  => 'notification',
                'type'  => 'select_from_array',
                'options' => [
                    1 => 'Enabled',
                    0 => 'Disabled'
                ]
            ]
        ];
    }
}

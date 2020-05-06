<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\OrderStatusHistory;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class OrderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OrderCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Order');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/orders');
        $this->crud->setEntityNameStrings('order', 'orders');

        $this->crud->addColumns(
            $this->getColumns()
        );
        $this->crud->addFields(
            $this->getFields()
        );

    }

    protected function setupListOperation()
    {
        $this->crud->addButtonFromModelFunction('line', 'generate_invoice', 'generateInvoice', 'beginning');

    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(OrderRequest::class);
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setValidation(OrderRequest::class);
    }


    public function show($id)
    {

        $order = $this->crud->getEntry($id);
        $orderStatuses = OrderStatus::get();
        $crud = $this->crud;

        return view('renders.order-view', compact('crud', 'order', 'orderStatuses'));
    }

    public function updateStatus(Request $request, OrderStatusHistory $orderStatusHistory)
    {
        // Create history entry
        $orderStatusHistory->create($request->except('_token'));

        $this->crud->update($request->input('order_id'), ['status_id' => $request->input('status_id')]);

        \Alert::success(__('order.status_updated'))->flash();

        return redirect()->back();
    }


    /**
     * @return array
     */
    private function getColumns()
    {
        return [
            [
                'name'  => 'id',
                'label' => '#',
            ],
            [
                'label'     => trans('client.client'),
                'type'      => 'select',
                'name'      => 'user_id',
                'entity'    => 'user',
                'attribute' => 'name',
                'model'     => 'App\User',
            ],
            [
                'label'     => trans('order.status'),
                'type'      => 'select',
                'name'      => 'status_id',
                'entity'    => 'status',
                'attribute' => 'name',
                'model'     => 'App\Models\OrderStatus',
            ],
            [
                'name'  => 'total',
                'label' => trans('common.total'),
            ],
            [
                'label'     => trans('currency.currency'),
                'type'      => 'select',
                'name'      => 'currency_id',
                'entity'    => 'currency',
                'attribute' => 'name',
                'model'     => 'App\Models\Currency',
            ],
            [
                'name'  => 'created_at',
                'label' => trans('order.created_at'),
            ]
        ];
    }

    /**
     * @return array
     */
    private function getFields()
    {
        return [];
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AttributeSetRequest;
use App\Models\Attribute;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class AttributeSetCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class AttributeSetCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\AttributeSet');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/attributes-sets');
        $this->crud->setEntityNameStrings('attribute set', 'attribute sets');

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
        $this->crud->setValidation(AttributeSetRequest::class);
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setValidation(AttributeSetRequest::class);

    }

    /**
     * @return array
     */
    private function getColumns()
    {
        return [
            [
                'name'  => 'name',
                'label' => trans('attribute.name'),
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
                'name'      => 'name',
                'label'     => trans('attribute.name'),
                'type'      => 'text',
            ],
            [
                'type'      => 'select2_multiple',
                'label'     => trans('attribute.attributes'),
                'name'      => 'attributes',
                'entity'    => 'attributes',
                'attribute' => 'name',
                'model'     => "App\Models\Attribute",
                'pivot'     => true,
            ]
        ];
    }


    public function ajaxGetAttributesBySetId(Request $request, Attribute $attribute)
    {
        // Init old as an empty array
        $old = [];

        // Set old inputs as array from $request
        if (isset($request->old)) {
            $old = json_decode($request->old, true);
        }

        // Get attributes with values by set id
        $attributes = $attribute->with('values')->whereHas('sets', function ($q) use ($request) {
            $q->where('id', $request->setId);
        })->get();

        return view('renders.product_attributes', compact('attributes', 'old'));
    }
}

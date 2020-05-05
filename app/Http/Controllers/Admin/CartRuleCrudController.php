<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CartRuleRequest;
use App\Models\CartRuleDiscountType;
use App\Models\Currency;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CartRuleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CartRuleCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\CartRule');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/cart-rules');
        $this->crud->setEntityNameStrings('cart rule', 'cart rules');

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
        $this->crud->setValidation(CartRuleRequest::class);
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setValidation(CartRuleRequest::class);

    }

    /**
     * @return array
     */
    private function getColumns()
    {
        return [
            [
                'name'  => 'name',
                'label' => trans('cartrule.name'),
                'type'  => 'text',
            ],
            [
                'name'  => 'code',
                'label' => trans('cartrule.code'),
            ],
            [
                'name'  => 'priority',
                'label' => trans('cartrule.priority'),
            ],
            [
                'name'  => 'start_date',
                'label' => trans('cartrule.start_date'),
            ],
            [
                'name'  => 'expiration_date',
                'label' => trans('cartrule.expiration_date'),
            ],
            [
                'name'  => 'status',
                'label' => trans('cartrule.status'),
            ],
        ];
    }

    /**
     * @return array
     */
    private function getFields()
    {
        $defaultCurrencyName = Currency::getDefaultCurrencyName();
        $defaultCurrencyId = Currency::getDefaultCurrencyId();

        return [
            [
                'name'      => 'name',
                'label'     => trans('cartrule.name'),
                'type'      => 'text',
                'attributes'=> ['required' => 'true'],
                'tab'       => trans('cartrule.information_tab'),
            ],
            [
                'name'  => 'code',
                'label' => trans('cartrule.code'),
                'tab'   => trans('cartrule.information_tab'),
            ],
            [
                'name'  => 'highlight',
                'label' => trans('cartrule.highlight'),
                'type'  => 'toggle_switch',
                'tab'   => trans('cartrule.information_tab'),
            ],
            [
                'name'      => 'priority',
                'label'     => trans('cartrule.priority'),
                'type'      => 'number',
                'attributes'=> [
                    'step'  => 'any',
                ],
                'tab'       => trans('cartrule.information_tab'),
            ],
            [
                'name'  => 'status',
                'label' => trans('cartrule.status'),
                'type'  => 'toggle_switch',
                'tab'   => trans('cartrule.information_tab'),
            ],
            [
                'name'  => 'promo_label',
                'label' => trans('cartrule.promo_label'),
                'tab'   => trans('cartrule.information_tab'),
            ],
            [
                'name'  => 'promo_text',
                'label' => trans('cartrule.promo_text'),
                'tab'   => trans('cartrule.information_tab'),
                'type'  => 'textarea',
            ],

            // CONDITIONS TAB
            [
                'name'      => 'customers',
                'label'     => trans('cartrule.customer_groups_rule'),
                'type'      => 'select2_multiple',
                'attribute' => 'name',
                'entity'    => 'customers',
                'model'     =>'App\Models\User',
                'pivot'     => true,
                'tab'       => trans('cartrule.conditions_tab'),
            ],
            [
                'name'  => 'start_date',
                'label' => trans('cartrule.start_date'),
                'type'  => 'datetime_picker',
                'tab'   => trans('cartrule.conditions_tab'),
            ],
            [
                'name'  => 'expiration_date',
                'label' => trans('cartrule.expiration_date'),
                'type'  => 'datetime_picker',
                'tab'   => trans('cartrule.conditions_tab'),
            ],
            [
                'name'      => 'total_available',
                'label'     => trans('cartrule.total_available'),
                'type'      => 'number',
                'attributes'=> [
                    'step'  => 'any',
                ],
                'tab'       => trans('cartrule.conditions_tab'),
            ],
            [
                'name'      => 'total_available_each_user',
                'label'     => trans('cartrule.total_available_each_user'),
                'type'      => 'number',
                'attributes'=> [
                    'step'  => 'any',
                ],
                'tab'       => trans('cartrule.conditions_tab'),
            ],
            [
                'name'      => 'min_nr_products',
                'label'     => trans('cartrule.min_nr_products'),
                'type'      => 'number',
                'attributes'=> [
                    'step'  => 'any',
                ],
                'tab'       => trans('cartrule.conditions_tab'),
            ],
            [
                'name'      => 'minimum_amount',
                'label'     => trans('cartrule.minimum_amount'),
                'type'      => 'number',
                'attributes'=> [
                    'step'  => 'any',
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-8'
                ],
                'tab'       => trans('cartrule.conditions_tab'),
            ],
            // @todo
//            [
//                'name'      => 'minimum_amount_currency_id',
//                'label'     => trans('cartrule.currency'),
//                'entity'    => 'currency',
//                'attribute' => 'name',
//                'model'     => 'App\Models\Currency',
//                'wrapperAttributes' => [
//                    'class' => 'form-group col-md-4'
//                ],
//                'type'      => 'select2_currency',
//                'default_currency'   => $defaultCurrencyName,
//                'default_currency_id' => $defaultCurrencyId,
//                'tab'       => trans('cartrule.conditions_tab'),
//            ],
            [
                'name'  => 'restrictions',
                'label' => '',
                'type'  => 'custom_html',
                'value' => '<h3>Restrictions</h3>',
                'tab'   => trans('cartrule.conditions_tab'),

            ],
            [
                'name'      => 'categories',
                'label'     => trans('cartrule.categories_rule'),
                'type'      => 'select2_multiple',
                'entity'    => 'categories',
                'attribute' => 'name',
                'model'     => 'App\Models\Category',
                'pivot'     => true,
                'tab'       => trans('cartrule.conditions_tab'),
            ],
            [
                'name'      => 'productGroups',
                'label'     => trans('cartrule.product_groups_rule'),
                'type'      => 'select2_multiple',
                'attribute' => 'id',
                'entity'    => 'productGroups',
                'model'     =>'App\Models\ProductGroup',
                'pivot'     => true,
                'tab'       => trans('cartrule.conditions_tab'),
            ],
            [
                'name'      => 'products',
                'label'     => trans('cartrule.products_rule'),
                'type'      => 'select2_multiple',
                'attribute' => 'name',
                'entity'    => 'products',
                'model'     =>'App\Models\Product',
                'pivot'     => true,
                'tab'       => trans('cartrule.conditions_tab'),
            ],
            [
                'name'      => 'compatibleCartRules',
                'label'     => trans('cartrule.compatible_with_rules'),
                'type'      => 'select2_multiple',
                'entity'    => 'compatibleCartRules',
                'attribute' => 'name',
                'model'     => 'App\Models\CartRule',
                'pivot'     => true,
                'tab'       => trans('cartrule.conditions_tab'),
            ],

            // ACTIONS TAB
            [
                'name'  => 'free_delivery',
                'label' => trans('cartrule.free_delivery'),
                'tab'   => trans('cartrule.actions_tab'),
                'type'  => 'toggle_switch',
            ],
            [
                'name' => 'discount_type',
                'label' => __('cartrule.actions_tab'),
                'type' => 'select_from_array',
                'options' => CartRuleDiscountType::pluck('name', 'id'),
                'allows_null' => false,
                'tab'   => trans('cartrule.actions_tab'),

            ],

            [
                'name'      => 'reduction_amount',
                'label'     => trans('cartrule.reduction_value'),
                'type'      => 'number',
                'attributes'=> [
                    'step'  => 'any',
                ],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-8'
                ],
                'tab'       => trans('cartrule.actions_tab'),
            ],
            [
                'name'              => 'reduction_currency_id',
                'label'             => trans('cartrule.currency'),
                'entity'            => 'currency',
                'attribute'         => 'name',
                'model'             => 'App\Models\Currency',
                'attributes'        => ['disabled' => 'disabled'],
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
                'type'      => 'select2_currency',
                'default_currency'   => $defaultCurrencyName,
                'default_currency_id' => $defaultCurrencyId,
                'tab'       => trans('cartrule.actions_tab'),
            ],
            [
                'name'      => 'send_free_gift',
                'label'     => trans('cartrule.send_free_gift'),
                'type'      => 'toggle_switch_free_gift',
                'attributes'=> ['field_to_enable' => 'gift_product_id',
                    'field_to_enable_2' => 'multiply_gift'],
                'tab'       => trans('cartrule.actions_tab'),
            ],
            [
                'name'      => 'gift_product_id',
                'label'     => trans('cartrule.gift'),
                'tab'       => trans('cartrule.actions_tab'),
                'type'      => 'select2',
                'entity'    => 'products',
                'attribute' => 'name',
                'model'     => 'App\Models\Product',
                'attributes'=> ['disabled' => 'disabled', ],
            ],
            [
                'name'      => 'multiply_gift',
                'label'     => trans('cartrule.multiply_gift'),
                'type'      => 'toggle_switch',
                'attributes'=> ['disabled' => 'disabled', ],
                'tab'       => trans('cartrule.actions_tab'),
            ],
        ];
    }
}


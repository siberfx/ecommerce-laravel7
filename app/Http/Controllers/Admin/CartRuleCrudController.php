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
                'label' => __('cartrule.name'),
                'type'  => 'text',
            ],
            [
                'name'  => 'code',
                'label' => __('cartrule.code'),
            ],
            [
                'name'  => 'priority',
                'label' => __('cartrule.priority'),
            ],
            [
                'name'  => 'start_date',
                'label' => __('cartrule.start_date'),
            ],
            [
                'name'  => 'expiration_date',
                'label' => __('cartrule.expiration_date'),
            ],
            [
                'name'  => 'status',
                'label' => __('cartrule.status'),
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
                'label'     => __('cartrule.name'),
                'type'      => 'text',
                'attributes'=> ['required' => 'true'],
                'tab'       => __('cartrule.information_tab'),
            ],
            [
                'name'  => 'code',
                'label' => __('cartrule.code'),
                'tab'   => __('cartrule.information_tab'),
            ],
            [
                'name'  => 'highlight',
                'label' => __('cartrule.highlight'),
                'type'  => 'toggle_switch',
                'tab'   => __('cartrule.information_tab'),
            ],
            [
                'name'      => 'priority',
                'label'     => __('cartrule.priority'),
                'type'      => 'number',
                'attributes'=> [
                    'step'  => 'any',
                ],
                'tab'       => __('cartrule.information_tab'),
            ],
            [
                'name'  => 'status',
                'label' => __('cartrule.status'),
                'type'  => 'toggle_switch',
                'tab'   => __('cartrule.information_tab'),
            ],
            [
                'name'  => 'free_delivery',
                'label' => __('cartrule.free_delivery'),
                'type'  => 'toggle_switch',
                'tab'   => __('cartrule.information_tab'),
            ],
            [
                'name'  => 'promo_label',
                'label' => __('cartrule.promo_label'),
                'tab'   => __('cartrule.information_tab'),
            ],
            [
                'name'  => 'promo_text',
                'label' => __('cartrule.promo_text'),
                'tab'   => __('cartrule.information_tab'),
                'type'  => 'textarea',
            ],

            // CONDITIONS TAB
            [
                'name'      => 'customers',
                'label'     => __('cartrule.customer_groups_rule'),
                'type'      => 'select2_multiple',
                'attribute' => 'name',
                'entity'    => 'customers',
                'model'     =>'App\Models\User',
                'pivot'     => true,
                'tab'       => __('cartrule.conditions_tab'),
            ],
            [
                'name'  => 'start_date',
                'label' => __('cartrule.start_date'),
                'type'  => 'datetime_picker',
                'tab'   => __('cartrule.conditions_tab'),
            ],
            [
                'name'  => 'expiration_date',
                'label' => __('cartrule.expiration_date'),
                'type'  => 'datetime_picker',
                'tab'   => __('cartrule.conditions_tab'),
            ],
            [
                'name'      => 'total_available',
                'label'     => __('cartrule.total_available'),
                'type'      => 'number',
                'attributes'=> [
                    'step'  => 'any',
                ],
                'tab'       => __('cartrule.conditions_tab'),
            ],
            [
                'name'      => 'total_available_each_user',
                'label'     => __('cartrule.total_available_each_user'),
                'type'      => 'number',
                'attributes'=> [
                    'step'  => 'any',
                ],
                'tab'       => __('cartrule.conditions_tab'),
            ],
            [
                'name'      => 'min_nr_products',
                'label'     => __('cartrule.min_nr_products'),
                'type'      => 'number',
                'attributes'=> [
                    'step'  => 'any',
                ],
                'tab'       => __('cartrule.conditions_tab'),
            ],

            [
                'name'  => 'restrictions',
                'label' => '',
                'type'  => 'custom_html',
                'value' => '<h3>Restrictions</h3>',
                'tab'   => __('cartrule.conditions_tab'),

            ],
            [
                'name'      => 'categories',
                'label'     => __('cartrule.categories_rule'),
                'type'      => 'select2_multiple',
                'entity'    => 'categories',
                'attribute' => 'name',
                'model'     => 'App\Models\Category',
                'pivot'     => true,
                'tab'       => __('cartrule.conditions_tab'),
            ],
            [
                'name'      => 'productGroups',
                'label'     => __('cartrule.product_groups_rule'),
                'type'      => 'select2_multiple',
                'attribute' => 'id',
                'entity'    => 'productGroups',
                'model'     =>'App\Models\ProductGroup',
                'pivot'     => true,
                'tab'       => __('cartrule.conditions_tab'),
            ],
            [
                'name'      => 'products',
                'label'     => __('cartrule.products_rule'),
                'type'      => 'select2_multiple',
                'attribute' => 'name',
                'entity'    => 'products',
                'model'     =>'App\Models\Product',
                'pivot'     => true,
                'tab'       => __('cartrule.conditions_tab'),
            ],
            [
                'name'      => 'compatibleCartRules',
                'label'     => __('cartrule.compatible_with_rules'),
                'type'      => 'select2_multiple',
                'entity'    => 'compatibleCartRules',
                'attribute' => 'name',
                'model'     => 'App\Models\CartRule',
                'pivot'     => true,
                'tab'       => __('cartrule.conditions_tab'),
            ],


        ];
    }
}


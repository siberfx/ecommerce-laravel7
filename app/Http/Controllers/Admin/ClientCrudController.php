<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest as ClientRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ClientCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ClientCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\User');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/clients');
        $this->crud->setEntityNameStrings('client', 'clients');
        $this->crud->addClause('whereHas', 'roles', function ($query) {
            $clientRoleName = env('CLIENT_ROLE_NAME');
            $query->whereName($clientRoleName ?: 'client');
        });

        /*
        |--------------------------------------------------------------------------
        | COLUMNS
        |--------------------------------------------------------------------------
        */
        $this->crud->addColumns([
            [
                'name'        => 'salutation',
                'label'       => __('client.salutation'),
            ],
            [
                'name'  => 'name',
                'label' => __('client.name'),
            ],
            [
                'name'      => 'gender',
                'label'     => __('client.gender'),
                'type'      => 'boolean',
                'options'   => [
                    1 => __('client.male'),
                    2 => __('client.female'),
                ],
            ],
            [
                'name'  => 'email',
                'label' => __('client.email'),
            ],
            [
                'name'      => 'active',
                'label'     => __('common.status'),
                'type'      => 'boolean',
                'options'   => [
                    0 => __('common.inactive'),
                    1 => __('common.active'),
                ],
            ]

        ]);

        /*
        |--------------------------------------------------------------------------
        | FIELDS
        |--------------------------------------------------------------------------
        */
        $this->setFields();



    }

    public function setFields()
    {
        $this->crud->addFields([
            [
                'name'  => 'salutation',
                'label' => __('client.salutation'),
                'type'  => 'text',

                'tab'   => __('client.tab_general'),
            ],
            [
                'name'  => 'name',
                'label' => __('client.name'),
                'type'  => 'text',

                'tab'   => __('client.tab_general'),
            ],
            [
                'name'  => 'email',
                'label' => __('client.email'),
                'type'  => 'email',

                'tab'   => __('client.tab_general'),
            ],
            [
                'name'  => 'password',
                'label' => __('client.password'),
                'type'  => 'password',

                'tab'   => __('client.tab_general'),
            ],
            [
                'name'  => 'password_confirmation',
                'label' => __('client.password_confirmation'),
                'type'  => 'password',

                'tab'   => __('client.tab_general'),
            ],
            [
                'name'      => 'gender',
                'label'     => __('client.gender'),
                'type'      => 'select_from_array',
                'options'   => [
                    1 => __('client.male'),
                    2 => __('client.female'),
                ],

                'tab'   => __('client.tab_general'),
            ],
            [
                'name'  => 'birthday',
                'label' => __('client.birthday'),
                'type'  => 'date',

                'tab'   => __('client.tab_general'),
            ],
            [
                'name'      => 'active',
                'label'     => __('common.status'),
                'type'      => 'select_from_array',
                'options'   => [
                    0 => __('common.inactive'),
                    1 => __('common.active'),
                ],

                'tab'   => __('client.tab_general'),
            ],
            [
                // two interconnected entities
                'label'             => __('permissionmanager.user_role_permission'),
                'field_unique_name' => 'user_role_permission',
                'type'              => 'checklist_dependency',
                'name'              => 'roles_and_permissions',
                'subfields'         => [
                    'primary' => [
                        'label'            => __('permissionmanager.roles'),
                        'name'             => 'roles',
                        'entity'           => 'roles',
                        'entity_secondary' => 'permissions',
                        'attribute'        => 'name',
                        'model'            => config('laravel-permission.models.role'),
                        'pivot'            => true,
                        'number_columns'   => 3, //can be 1,2,3,4,6
                    ],
                    'secondary' => [
                        'label'          => ucfirst(__('permissionmanager.permission_singular')),
                        'name'           => 'permissions',
                        'entity'         => 'permissions',
                        'entity_primary' => 'roles',
                        'attribute'      => 'name',
                        'model'          => "Backpack\PermissionManager\app\Models\Permission",
                        'pivot'          => true,
                        'number_columns' => 3, //can be 1,2,3,4,6
                    ],
                ],

                'tab'   => __('client.tab_permissions'),
            ],
        ]);

        $this->crud->addField([
            'name'          => 'client_address',
            'type'          => 'client_address',
            'country_model' => Country::class,

            'tab'           => __('client.tab_address'),
        ], 'update');

        $this->crud->addField([
            'name'          => 'client_company',
            'type'          => 'client_company',
            'country_model' => 'App\Models\Company',

            'tab'           => __('client.tab_company'),
        ], 'update');
    }


    /**
     * Handle password input fields.
     *
     * @param CrudRequest $request
     */
    protected function handlePasswordInput(CrudRequest $request)
    {
        // Remove fields not present on the user.
        $request->request->remove('password_confirmation');

        // Encrypt password if specified.
        if ($request->input('password')) {
            $request->request->set('password', bcrypt($request->input('password')));
        } else {
            $request->request->remove('password');
        }
    }
}

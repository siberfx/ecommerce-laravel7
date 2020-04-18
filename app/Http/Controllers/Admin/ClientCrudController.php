<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserStoreRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\PermissionManager\app\Http\Requests\UserUpdateCrudRequest;

/**
 * Class ClientCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 *
 * @todo create or update has problem because of password confirmation issue
 */
class ClientCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation { store as traitStore; }
    use UpdateOperation { update as traitUpdate; }
    use DeleteOperation;
    use ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\User');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/clients');
        $this->crud->setEntityNameStrings('client', 'clients');

        $this->crud->addColumns(
            $this->getColumns()
        );
        $this->crud->addFields(
            $this->getFields()
        );

        if ( request()->segment(4) === 'edit' ) {

            $this->crud->addFields([
                [
                    'name'          => 'client_address',
                    'type'          => 'client_address',
                    'country_model' => 'App\Models\Country',

                    'tab'           => __('client.tab_address'),
                ],
                [
                    'name'          => 'client_company',
                    'type'          => 'client_company',
                    'country_model' => 'App\Models\Company',

                    'tab'           => __('client.tab_company'),
                ],
            ]);

        }

    }

    protected function setupListOperation()
    {
        $this->crud->addClause('whereHas', 'roles', function ($query) {
            $clientRoleName = env('CLIENT_ROLE_NAME');
            $query->whereName($clientRoleName ?: 'client');
        });

    }

    public function store(UserStoreRequest $request)
    {

        $request->request->set('password' , bcrypt($this->crud->request->input('password')));

        $response = $this->traitStore();
        // $clientRoleID = \DB::table('roles')->whereName($clientRoleName ?: 'client')->first()->id;
        // $this->crud->entry->roles()->attach($clientRoleID);

        return $response;
    }

    public function update(UserUpdateCrudRequest $request)
    {
        $request->request->set('password' , bcrypt($this->crud->request->input('password')));

        $response = $this->traitUpdate();

        return $response;
    }

    /**
     * @return array
     */
    private function getColumns()
    {
        return [
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
        ];
    }

    /**
     * @return array
     */
    private function getFields()
    {
        return [
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
                        'model'            => config('permission.models.role'),
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
        ];
    }

}

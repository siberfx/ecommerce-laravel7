<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NotificationTemplateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class NotificationTemplateCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class NotificationTemplateCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\NotificationTemplate');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/notification-templates');
        $this->crud->setEntityNameStrings('', 'notification templates');

        $this->crud->addColumns(
            $this->getColumns()
        );
        $this->crud->addFields(
            $this->getFields()
        );

    }

    protected function setupListOperation()
    {
        //
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(NotificationTemplateRequest::class);
    }

    protected function setupUpdateOperation()
    {
        $this->crud->setValidation(NotificationTemplateRequest::class);
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
                'label'     => trans('notification_templates.name'),
                'type'      => 'text',
                'name'      => 'name',
            ],
            [
                'label'     => trans('notification_templates.model'),
                'type'      => 'text',
                'name'      => 'model',
            ],
            [
                'label'     => trans('notification_templates.slug'),
                'type'      => 'text',
                'name'      => 'name',
            ],
        ];
    }

    /**
     * @return array
     */
    private function getFields()
    {
        $availableModels = [
            'User' => 'App\Models\User',
            'Order' => 'App\Models\Order'
        ];

        return [
            [
                'name'  => 'name',
                'label' => trans('notification_templates.name'),
                'type'  => 'text',
            ],
            [
                'name'  => 'slug',
                'label' => trans('notification_templates.slug'),
                'type'  => 'slug',
                // 'attributes' => ['disabled' => 'disabled']
            ],
            [
                'name'    => 'model',
                'label'   => trans('notification_templates.model'),
                'type'    => 'select2_from_array_notification_template_model',
                'options' => $availableModels
            ],
            [
                'name'  => 'body',
                'label' => trans('notification_templates.body'),
                'type'  => 'ckeditor',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-9 col-xs-12'
                ]
            ],
            [
                'name'  => 'notification_list_variables',
                'label' => trans('notification_templates.available_variables'),
                'type'  => 'notification_list_variables',
                'wrapperAttributes' => [
                    'class' => 'form-group available-variables col-md-3 col-xs-12'
                ]
            ],
        ];
    }

    public function listModelVars()
    {
        $modelClass = 'App\\Models\\'.$this->crud->request->model;

        if ($this->crud->request->model === 'User') {
            $modelClass = 'App\\'.$this->crud->request->model;
        }

        if (class_exists($modelClass)) {
            $model = new $modelClass;

            return response()->json($model->notificationVars);
        }

        return null;
    }


    /**
     * Get model variables available to use in an email template
     * @param  string $modelName
     * @return array
     */
    public function getModelVariables($modelName)
    {
        $modelClass = 'App\\Models\\'.$modelName;

        if ($modelName === 'User') {
            $modelClass = 'App\\'.$modelName;
        }

        if (class_exists($modelClass)) {
            $model = new $modelClass;
        }

        return $model->notificationVars;
    }

    /**
     * Check variables in body to match the available variables from the model
     * @param  $request
     * @return boolean
     */
    public function checkModelVariables($request) {
        preg_match_all('/(\{{2}\s?(.*?)\s?\}{2})/mi',
            $request->body,
            $out, PREG_PATTERN_ORDER);

        if (count(array_diff($out[2], $this->getModelVariables($request->model))) > 0)  {
            return false;
        }
        return true;
    }

}

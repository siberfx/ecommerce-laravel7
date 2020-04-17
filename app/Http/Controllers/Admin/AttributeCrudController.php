<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AttributeRequest;
use App\Models\AttributeValue;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AttributeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AttributeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Attribute');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/attribute');
        $this->crud->setEntityNameStrings('attribute', 'attributes');

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



    public function store(AttributeRequest $request)
    {
        $response = $this->traitStore();

        $entryId = $this->crud->entry->id;


        // Define Storage disk for media attribute type
        $disk = "attributes";

        // Init attributeValue array
        $attributeValue = [];

        switch($request->type) {
            case 'text':
            case 'textarea':
            case 'date':
                $attributeValue = [
                    'attribute_id' => $entryId,
                    'value'        => $request->{$request->type}
                ];
                break;

            case 'multiple_select':
            case 'dropdown':
                foreach ($request->option as $option) {
                    $attributeValue[] = [
                        'attribute_id' => $entryId,
                        'value'        => $option
                    ];
                }
                break;

            case 'media':
                if (starts_with($request->media, 'data:image')) {
                    // 1. Make the image
                    $image = \Image::make($request->media);
                    // 2. Generate a filename.
                    $filename = md5($request->media.time()).'.jpg';
                    // 3. Store the image on disk.
                    \Storage::disk($disk)->put($filename, $image->stream());
                    // 4. Save the path to attributes_value
                    $attributeValue = ['attribute_id' => $entryId, 'value' => $filename];
                }
                break;
        }

        $insert_attribute_values = AttributeValue::insert($attributeValue);

        return $response;
    }

    public function update(AttributeRequest $request, AttributeValue $attributeValue)
    {
        // Define Storage disk for media attribute type
        $disk = 'attributes';

        switch ($request->type) {
            case 'text':
            case 'textarea':
            case 'date':
                $attributeValue->where('attribute_id', $request->id)->update(['value' => $request->{$request->type}]);
                break;

            case 'multiple_select':
            case 'dropdown':
                if (isset($request->current_option)) {
                    foreach ($request->current_option as $key => $current_option) {
                        $attributeValue->where('id', $key)->update(['value' => $current_option]);
                    }
                }

                if (isset($request->option)) {
                    foreach ($request->option as $option) {
                        $attribute_values[] = ['attribute_id' => $request->id, 'value' => $option];
                    }

                    $insert_new_option = $attributeValue->insert($attribute_values);
                }
                break;

            case 'media':
                if (starts_with($request->media, 'data:image')) {
                    // 0. Get current image filename
                    $current_image_filename = $attributeValue->where('attribute_id', $request->id)->first()->value;
                    // 1. delete image file if exist
                    if (\Storage::disk($disk)->has($current_image_filename)) {
                        \Storage::disk($disk)->delete($current_image_filename);
                    }
                    // 2. Make the image
                    $image = \Image::make($request->media);
                    // 3. Generate a filename.
                    $filename = md5($request->media.time()).'.jpg';
                    // 4. Store the image on disk.
                    \Storage::disk($disk)->put($filename, $image->stream());
                    // 5. Update image filename to attributes_value
                    $attributeValue->where('attribute_id', $request->id)->update(['value' => $filename]);
                }
                break;

                $response = $this->traitUpdate();
                return $response;
        }

    }




    /**
     * @return array
     */
    private function getColumns()
    {
        return [
            [
                'name'  => 'name',
                'label' => __('attribute.name'),
            ],
            [
                'name'  => 'type',
                'label' => __('attribute.type'),
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
                'label' => __('attribute.name'),
                'type'  => 'text',
            ],
            [
                'name'    => 'type',
                'label'   => __('attribute.type'),
                'type'    => 'select_from_array',
                'options' => [
                    '0'                 => '--',
                    'text'              => __('attribute.text'),
                    'textarea'          => __('attribute.textarea'),
                    'date'              => __('attribute.date'),
                    'multiple_select'   => __('attribute.multiple_select'),
                    'dropdown'          => __('attribute.dropdown'),
                    'media'             => __('attribute.media')
                ],
                'attributes' => [
                    'id' => 'attribute_type'
                ]
            ],
            [
                'name'          => "media",
                'label'         => __('attribute.default')." ".__('attribute.media'),
                'type'          => 'attribute_type_image',
                'default'       => 'default.png',
                'disk'          => 'attributes',
                'upload'        => true,
                'aspect_ratio'  => 0,
            ],
            [
                'name'  => 'attribute_types',
                'label' => __('attribute.name'),
                'type'  => 'attribute_types',
            ]
        ];
    }





}

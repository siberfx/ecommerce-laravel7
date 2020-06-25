
@include('crud::fields.inc.wrapper_start')
    <div class="dropzone sortable dz-clickable sortable">
        <div class="dz-message">
            Drop files here or click to upload.
        </div>


        @if ( $entry->images->count() )
            @foreach($entry->images as $image)
                <div class="dz-preview" data-id="{{ $image->id }}">
                    <img class="dropzone-thumbnail" src={{ '/storage/portfolio/'.$image->name }}>
                    <a class="dz-remove" href="javascript:void(0);" data-remove="{{ $image->id }}">{{ __('backend.delete_image') }}</a>
                </div>
            @endforeach
        @endif
    </div>
@include('crud::fields.inc.wrapper_end')


@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))
    {{-- FIELD EXTRA CSS  --}}
    {{-- push things in the after_styles section --}}

    @push('crud_fields_styles')
        <style>
            .sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; overflow: auto;}
            .sortable { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 120px; height: 120px; vertical-align:bottom; text-align: center;}
            .dropzone-thumbnail {
                width: 120px;
                height: 120px;
                cursor: move !important;
            }
            .dropzone {
                width: 100%;
                height: 270px;
            }
        </style>
    @endpush


    {{-- FIELD EXTRA JS --}}
    {{-- push things in the after_scripts section --}}

    @push('crud_fields_scripts')

        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>
        <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">

        <script>
            Dropzone.autoDiscover = false;
            var uploaded = false;

            var dropzone = new Dropzone(".dropzone", {
                url: "{{ route('uploadProductImages') }}",
                uploadMultiple: true,
                acceptedFiles: '{{ implode(',',$field['mimes']) }}',
                addRemoveLinks: true,
                // autoProcessQueue: false,
                maxFilesize: {{ $field['filesize'] }},
                parallelUploads: 10,
                // previewTemplate:
                sending: function(file, xhr, formData) {
                    formData.append("_token", $('[name=_token').val());
                    formData.append("id", {{ $entry->id }});
                },
                error: function(file, response) {

                    $(file.previewElement).find('.dz-error-message').remove();
                    $(file.previewElement).remove();

                    $(function(){

                        swal({
                            title: file.name+" was not uploaded!",
                            text: response,
                            icon: "error",
                            buttons: false,
                        });
                    });

                },
                success : function(file, images){
                    $('.dropzone').empty();
                    $.each(images, function(index, val) {
                        $('.dropzone').append('<div class="dz-preview" data-id="'+val.id+'"><img class="dropzone-thumbnail" src="{{ url(config('filesystems.disks.products.simple_path')) }}/'+val.name+'" /><a class="dz-remove" href="javascript:void(0);" data-remove="'+val.id+'">Remove file</a></div>')
                    });

                    $(function(){
                        swal({
                            title: false,
                            text: 'Image(s) was successfully uploaded!',
                            icon: "success",
                            timer: 1000,
                            buttons: false,
                        });
                    });
                }
            });

            // Reorder images
            $(".dropzone").sortable({
                items: '.dz-preview',
                cursor: 'move',
                opacity: 0.5,
                containment: '.dropzone',
                distance: 20,
                scroll: true,
                tolerance: 'pointer',
                stop: function (event, ui) {
                    var idsOrder = [];

                    $('.dz-preview').each(function() {
                        idsOrder.push($(this).data('id'))
                    });

                    $.ajax({
                        url: '{{ route('reorderProductImages') }}',
                        type: 'POST',
                        data: {
                            order: idsOrder,
                        },
                    })
                        .done(function(resp) {
                            console.log(resp);
                        });
                }
            });

            // Delete image
            $(document).on('click', '.dz-remove', function () {
                var id = $(this).data('remove');

                $.ajax({
                    url: '{{ route('deleteProductImage') }}',
                    type: 'POST',
                    data: {
                        id: id
                    },
                })
                    .done(function(status) {
                        var notification_type;

                        if (status.success) {
                            notification_type = 'success';
                            $('div.dz-preview[data-id="'+id+'"]').remove();
                        } else {
                            notification_type = 'error';
                        }

                        $(function(){

                            swal({
                                text: status.message,
                                type: notification_type,
                                icon: false
                            });
                        });
                    });

            });

        </script>

    @endpush
@endif

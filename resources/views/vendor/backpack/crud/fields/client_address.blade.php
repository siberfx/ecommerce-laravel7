<div class="row">
    <div class="col-md-12">

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addAddressModal">
            <i class="fa fa-plus"></i> Add
        </button>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-12">
        <div id="client_addresses"></div>
    </div>
</div>

<!-- Add address modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1" role="dialog" aria-labelledby="addAddressModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('address.add_address') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('common.close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="add-address-fields">
                <div class="modal-body">
                    <input type="hidden" name="address[client_id]" value="{{ $entry->id }}">

                    <div class="form-group">
                        <label for="name">{{ __('address.contact_person') }}:</label>
                        <input type="text" class="form-control" name="address[name]" id="name">
                    </div>

                    <div class="form-group">
                        <label for="address1">{{ __('address.address_1') }}:</label>
                        <input type="text" class="form-control" name="address[address1]" id="address1">
                    </div>

                    <div class="form-group">
                        <label for="address2">{{ __('address.address_2') }}:</label>
                        <input type="text" class="form-control" name="address[address2]" id="address2">
                    </div>

                    <div class="form-group">
                        <label for="country">{{ __('address.country') }}:</label>
                        <select name="address[country_id]" class="form-control select2_field" style="width: 100%;" id="country">
                            @foreach($field['country_model']::get() as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="county">{{ __('address.county') }}:</label>
                                <input type="text" class="form-control" name="address[county]" id="county">
                            </div>

                            <div class="col-md-6">
                                <label for="city">{{ __('address.city') }}:</label>
                                <input type="text" class="form-control" name="address[city]" id="city">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="postal_code">{{ __('address.postal_code') }}:</label>
                        <input type="text" class="form-control" name="address[postal_code]" id="postal_code">
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="phone">{{ __('address.phone') }}:</label>
                                <input type="text" class="form-control" name="address[phone]" id="phone">
                            </div>

                            <div class="col-md-6">
                                <label for="mobile_phone">{{ __('address.mobile_phone') }}:</label>
                                <input type="text" class="form-control" name="address[mobile_phone]" id="mobile_phone">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="comment">{{ __('address.comment') }}:</label>
                        <textarea name="address[comment]" class="form-control" id="comment" rows="3"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('common.cancel') }}</button>
                    <button type="button" class="btn btn-primary btn-add-address">{{ __('common.add') }}</button>
                </div>
            </div>
        </div>

    </div>
</div>



@push('crud_fields_styles')
@endpush

@push('crud_fields_scripts')
    <script>
        // List client addresses
        function getClientAddresses(client_id = null) {
            $.ajax({
                url: '{{ route('getClientAddresses') }}',
                type: 'POST',
                data: {
                    client_id: client_id
                },
            })
            .done(function(resp) {
                $('#client_addresses').html(resp);
            })
            .fail(function(resp) {
                // Show error message
                $(function(){
                  swal({
                    text: '{{ __('common.error_occurred') }}',
                    type: 'error',
                  });
                });
            });
        }


        // Add new address
        $(document).on('click', '.btn-add-address', function (e) {
            $.ajax({
                url: '{{ route('addClientAddress') }}',
                type: 'POST',
                data: $('#add-address-fields :input').serialize(),
            })
            .done(function(resp) {
                // Close modal
                $('.add-address-modal').modal('hide');

                // Reload client addresses
                getClientAddresses({{ $entry->id }});

                // Show success message
                $(function(){
                  swal({
                    text: '{{ __('address.address_created') }}',
                    type: 'success',
                  });
                });
            })
            .fail(function() {
                // Close modal
                $('.add-address-modal').modal('hide');

                // Show error message
                $(function(){
                  swal({
                    text: '{{ __('common.error_occurred') }}',
                    type: 'error',
                  });
                });
            });
        });

        // Delete address
        $(document).on('click', '.btn-delete-address', function (){
            var confirmation = confirm("{{ __('address.delete_address_confirm') }}");
            if (confirmation) {
                var addressId = $(this).data('address-id');

                $.ajax({
                    url: '{{ route('deleteClientAddress') }}',
                    type: 'POST',
                    data: {
                        id: addressId,
                    },
                })
                .done(function() {
                    // Reload client addresses
                    getClientAddresses({{ $entry->id }});

                    // Show success message
                    $(function(){
                      swal({
                        text: '{{ __('address.address_deleted') }}',
                        type: 'success',
                      });
                    });
                })
                .fail(function() {
                    // Show error message
                    $(function(){
                      swal({
                        text: '{{ __('common.error_occurred') }}',
                        type: 'error',
                      });
                    });
                });

            }
        });

        $(document).ready(function () {
            // List client addresses
            getClientAddresses({{ $entry->id }});
        });
    </script>
@endpush

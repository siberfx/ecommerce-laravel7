<div class="row">
    <div class="col-md-12">

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCompanyModal">
            <i class="fa fa-plus"></i> {{ trans('company.add_company') }}
        </button>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-12">
        <div id="client_companies"></div>
    </div>
</div>

<div class="modal fade" id="addCompanyModal" tabindex="-1" role="dialog" aria-labelledby="addCompanyModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('company.add_company') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('common.close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="add-company-fields">
                <div class="modal-body">
                    <input type="hidden" name="company[client_id]" value="{{ $entry->id ?? '' }}">

                    <div class="form-group">
                        <label for="name">{{ trans('company.company_name') }}:</label>
                        <input type="text" class="form-control" name="company[name]" id="name">
                    </div>

                    <div class="form-group">
                        <label for="address1">{{ trans('company.address_1') }}:</label>
                        <input type="text" class="form-control" name="company[address1]" id="address1">
                    </div>

                    <div class="form-group">
                        <label for="address2">{{ trans('company.address_2') }}:</label>
                        <input type="text" class="form-control" name="company[address2]" id="address2">
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="county">{{ trans('company.county') }}:</label>
                                <input type="text" class="form-control" name="company[county]" id="county">
                            </div>

                            <div class="col-md-6">
                                <label for="city">{{ trans('company.city') }}:</label>
                                <input type="text" class="form-control" name="company[city]" id="city">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="tin">{{ trans('company.tin') }}:</label>
                                <input type="text" class="form-control" name="company[tin]" id="tin">
                            </div>

                            <div class="col-md-6">
                                <label for="trn">{{ trans('company.trn') }}:</label>
                                <input type="text" class="form-control" name="company[trn]" id="trn">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('common.cancel') }}</button>
                    <button type="button" class="btn btn-primary btn-add-company">{{ trans('common.add') }}</button>
                </div>
            </div>
        </div>

    </div>
</div>



@push('crud_fields_styles')
@endpush

@push('crud_fields_scripts')
    <script>

        // List client companies
        function getClientCompanies(client_id = null) {
            $.ajax({
                url: '{{ route('getClientCompanies') }}',
                type: 'POST',
                data: {
                    client_id: client_id
                },
            })
                .done(function(response) {
                    $('#client_companies').html(response);
                })
                .fail(function(response) {
                    // Show error message
                    $(function(){
                        swal({
                            text: '{{ trans('common.error_occurred') }}',
                            type: 'error',
                            icon: false
                        });
                    });
                });
        }


        // Add new company
        $(document).on('click', '.btn-add-company', function (e) {
            $.ajax({
                url: '{{ route('addClientCompany') }}',
                type: 'POST',
                data: $('#add-company-fields :input').serialize(),
            })
                .done(function(response) {
                    // Close modal
                    $('.add-company-modal').modal('hide');

                    // Reload client companies
                    getClientCompanies({{ $entry->id }});

                    // Show success message
                    $(function(){
                        swal({
                            text: '{{ trans('company.company_created') }}',
                            type: 'success',
                            icon: false
                        });
                    });
                })
                .fail(function() {
                    // Close modal
                    $('.add-company-modal').modal('hide');

                    // Show error message
                    $(function(){
                        swal({
                            text: '{{ trans('common.error_occurred') }}',
                            type: 'error',
                            icon: false
                        });
                    });
                });
        });

        // Delete company
        $(document).on('click', '.btn-delete-company', function (){
            var confirmation = confirm("{{ trans('company.delete_company_confirm') }}");
            if (confirmation) {
                var companyId = $(this).data('company-id');

                $.ajax({
                    url: '{{ route('deleteClientCompany') }}',
                    type: 'POST',
                    data: {
                        id: companyId,
                    },
                })
                    .done(function() {
                        // Reload client companies
                        getClientCompanies({{ $entry->id ?? '' }});

                        // Show success message
                        $(function(){
                            swal({
                                text: '{{ trans('company.company_deleted') }}',
                                type: 'success',
                                icon: false
                            });
                        });
                    })
                    .fail(function() {
                        // Show error message
                        $(function(){
                            swal({
                                text: '{{ trans('common.error_occurred') }}',
                                type: 'error',
                                icon: false
                            });
                        });
                    });

            }
        });

        $(document).ready(function () {
            // List client companies
            getClientCompanies({{ $entry->id }});
        });
    </script>
@endpush

@extends(backpack_view('blank'))

@section('header')
    <div class="container-fluid">
        <h2>
            <span class="text-capitalize">{{ __('import.title') }}</span>
        </h2>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-8">

            <!-- Default box -->
            <div class="">
                <div class="card no-padding no-border">
                    <div class="mt-4">
                        <div class="{{ '' }}">
                            <div class="py-4 px-4">
                                <p>{{ __('import.slang') }}</p>
                                <form method="post" action="{{ route('import-contacts-post') }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-group">

                                        <div class="custom-file">
                                            <input type="file" name="file" class="custom-file-input"
                                                   id="inputGroupFile01"
                                                   aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" for="inputGroupFile01">{{ __('import.browse') }}</label>
                                        </div>
                                        <div class="form-group">
                                            <input class="btn btn-primary" type="submit" name="submit">
                                        </div>
                                    </div>
                                </form>

                            </div><!-- /.card -->

                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

        </div>
    </div>
@endsection

@section('after_styles')

@endsection

@section('after_scripts')
    <script>
        jQuery(document).ready(function ($) {
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    // Show an alert with the result
                    new Noty({
                        text: "{{ $error }}",
                        type: "error"
                    }).show();
                @endforeach
            @elseif(session()->has('message'))
                new Noty({
                    text: "{{ session()->get('message') }}",
                    type: "success"
                }).show();
            @endif
        });
    </script>

@endsection

@if ($crud->hasAccess('import'))
    <a href="{{ url($crud->route.'/import') }}" class="mx-2 btn btn-outline-warning" data-style="zoom-in">
        <span class="ladda-label"><i class="la la-file-csv"></i> {{ trans('import.title') }} </span>
    </a>
    {!! __('contacts.export-sample', ['csv' => '<a href="/demo-dataset/empty.csv">CSV</a>', 'xlsx' => '<a href="/demo-dataset/empty.xlsx">XLSX</a>']) !!}

@endif

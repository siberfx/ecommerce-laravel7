@if ($crud->hasAccess('update'))
    <a class="btn btn-sm btn-link dropdown-toggle text-primary pl-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="caret"></span>Actions
    </a>

    <ul class="dropdown-menu dropdown-menu-right" style="">
        <a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/moneybird') }}">{{ trans('Send to Moneybird') }}</a>
    </ul>

@endif

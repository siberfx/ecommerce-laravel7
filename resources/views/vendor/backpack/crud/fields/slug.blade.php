<!-- text input -->
@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')

    @if(isset($field['prefix']) || isset($field['suffix'])) <div class="input-group"> @endif
        @if(isset($field['prefix'])) <div class="input-group-addon">{!! $field['prefix'] !!}</div> @endif
        <input
            type="text"
            name="{{ $field['name'] }}"
            @if(isset($entry)) readonly="readonly" @endif
            value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}"
            @include('crud::fields.inc.attributes')
        >
        @if(isset($field['suffix'])) <div class="input-group-addon">{!! $field['suffix'] !!}</div> @endif
        @if(isset($field['prefix']) || isset($field['suffix'])) </div> @endif

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
@include('crud::fields.inc.wrapper_end')


{{-- FIELD EXTRA CSS  --}}
{{-- push things in the after_styles section --}}

{{-- @push('crud_fields_styles')
    <!-- no styles -->
@endpush --}}


{{-- FIELD EXTRA JS --}}
{{-- push things in the after_scripts section --}}

{{-- @push('crud_fields_scripts')
    <!-- no scripts -->
@endpush --}}


{{-- Note: you can use @if ($crud->checkIfFieldIsFirstOfItsType($field, $fields)) to only load some CSS/JS once, even though there are multiple instances of it --}}

@php
    $value = data_get($entry, $column['name']);
    $column['prefix'] = $column['prefix'] ?? '';
    $column['escaped'] = $column['escaped'] ?? true;
    $column['wrapper']['element'] = $column['wrapper']['element'] ?? 'a';
    $column['wrapper']['target'] = $column['wrapper']['target'] ?? '_blank';
@endphp

<span>
    @if ($value && count($value))
        @foreach ($value as $file_path)
        @php
            $column['wrapper']['href'] = $column['wrapper']['href'] ?? ( isset($column['disk'])?asset(\Storage::disk($column['disk'])->url($file_path)):asset($column['prefix'].$file_path) );
            $text = $column['prefix'].$file_path;
        @endphp
            @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
            @if($column['escaped'])
                - {{ $text }} <br/>
            @else
                - {!! $text !!} <br/>
            @endif
        @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
        @endforeach
    @else
        -
    @endif
</span>

@php

    $hdrType = "";

    if (isset($parameters['hdr_type'])) {
        $hdrType = $parameters['hdr_type'];    
    }

@endphp

<div class="form-group">
    <label>Header type</label>
    <select name="parameters[hdr_type]" class="form-control">
        @for ($i = 1; $i <= 5; $i++)
            <option value="{{ $i }}" @if((int)($hdrType) === $i) selected @endif>Type {{ $i }}</option>
        @endfor
    </select>
</div>

@php

    $value1 = "";
    $value2 = "";

    if (isset($parameters['param3'])) {
        $value1 = $parameters['param3'];    
    }

    if (isset($parameters['param4'])) {
        $value2 = $parameters['param4'];    
    }

@endphp

<div class="form-group">
    <label>Parameter 3</label>
    <input class="form-control" name="parameters[param3]" value="{{ $value1 }}" />
</div>
<div class="form-group">
    <label>Parameter 4</label>
    <input class="form-control" name="parameters[param4]" value="{{ $value2 }}" />
</div>
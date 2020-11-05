@php

    $value1 = "";
    $value2 = "";

    if (isset($parameters['param1'])) {
        $value1 = $parameters['param1'];    
    }

    if (isset($parameters['param2'])) {
        $value2 = $parameters['param2'];    
    }

@endphp

<div class="form-group">
    <label>Parameter 1</label>
    <input class="form-control" name="parameters[param1]" value="{{ $value1 }}" />
</div>
<div class="form-group">
    <label>Parameter 2</label>
    <input class="form-control" name="parameters[param2]" value="{{ $value2 }}" />
</div>

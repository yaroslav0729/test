@php

    $value1 = "";
    $value2 = "";

    if (isset($parameters['param3'])) {
        $value1 = $parameters['param4'];    
    }

    if (isset($parameters['param3'])) {
        $value2 = $parameters['param4'];    
    }

@endphp
<div class="container p-3">
    <div class="form-group">
        <h1>Parameter 3: {{ $value1 }}</h1>
    </div>
    <div class="form-group">
        <h2>Parameter 4: {{ $value2 }}</h2>
    </div>
</div>
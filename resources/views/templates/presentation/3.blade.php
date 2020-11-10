@php

    $value1 = "";
    $value2 = "";
    $articleHtml = "";

    if (isset($parameters['param3'])) {
        $value1 = $parameters['param3'];    
    }

    if (isset($parameters['param3'])) {
        $value2 = $parameters['param4'];    
    }

    if (isset($parameters['article_html'])) {
        $articleHtml = $parameters['article_html'];    
    }

@endphp
<div class="container p-3">
    <div class="form-group">
        <p>Parameter 3: {{ $value1 }}</p>
    </div>
    <div class="form-group">
        <p>Parameter 4: {{ $value2 }}</p>
    </div>

    <div class="mt-3">
        {!! $articleHtml !!}
    </div>
</div>
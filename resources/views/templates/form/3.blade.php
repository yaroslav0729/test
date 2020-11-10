@php

    $value1 = "";
    $value2 = "";
    $articleHtml = "";

    if (isset($parameters['param3'])) {
        $value1 = $parameters['param3'];    
    }

    if (isset($parameters['param4'])) {
        $value2 = $parameters['param4'];    
    }

    if (isset($parameters['article_html'])) {
        $articleHtml = $parameters['article_html'];    
    }

@endphp

<div class="form-group">
    <label>Parameter 3</label>
    <input class="form-control" placeholder="Test parameter 3" name="parameters[param3]" value="{{ $value1 }}" />
</div>
<div class="form-group">
    <label>Parameter 4</label>
    <input class="form-control" placeholder="Test parameter 4" name="parameters[param4]" value="{{ $value2 }}" />
</div>
<div class="form-group">
    <label>Article html</label>
    <textarea wysiwyg-editor class="form-control" id="article_html" name="parameters[article_html]">{{ $articleHtml }}</textarea>
</div>
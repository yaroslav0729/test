@php

    $mainHtml = "";

    if (isset($parameters['main_html'])) {
        $mainHtml = $parameters['main_html'];
    }

@endphp

<div class="form-group">
    <label for="main_html">Main content:</label>
    <textarea wysiwyg-editor id="main_html" class="form-control" name="parameters[main_html]" placeholder="Insert main content here">{{ $mainHtml }}</textarea>
</div>

@include('modules.admin.related_page_expanded', [
    'parameters' => $parameters
])

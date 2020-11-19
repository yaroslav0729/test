@php

    $mainHtml = "";
    $importantInfoTitle = "";
    $importantInfo = "";

    if (isset($parameters['main_html'])) {
        $mainHtml = $parameters['main_html'];    
    }

    if (isset($parameters['important_title'])) {
        $importantInfoTitle = $parameters['important_title'];    
    }

    if (isset($parameters['important_text'])) {
        $importantInfo = $parameters['important_text'];    
    }

@endphp

<div class="form-group">
    <label>Main page content</label>
    <textarea wysiwyg-editor id="main_page" class="form-control" name="parameters[main_html]" placeholder="Insert main page content text">{{ $mainHtml }}</textarea>
</div>

<div class="form-group">
    <label>Important info title</label>
    <input class="form-control" required name="parameters[important_title]" placeholder="Insert important info title" value="{{ $importantInfoTitle }}" />
</div>

<div class="form-group">
    <label>Important info text</label>
    <textarea class="form-control" placeholder="Insert important info text" name="parameters[important_text]">{{ $importantInfo }}</textarea>
</div>

@include('modules.admin.projects_donate', ['parameters' => $parameters])
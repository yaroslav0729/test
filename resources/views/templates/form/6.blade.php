@php

    $mainHtml = "";

    if (isset($parameters['main_html'])) {
        $mainHtml = $parameters['main_html'];    
    }

    $projHeading = "";

    if (isset($parameters['proj_heading'])) {
        $projHeading = $parameters['proj_heading'];    
    }

@endphp

<div class="form-group">
    <label>Project heading:</label>
    <input class="form-control" name="parameters[proj_heading]" placeholder="Insert project heading" value="{{ $projHeading }}" />
</div>

<div class="form-group">
    <label>Main page content</label>
    <textarea wysiwyg-editor id="main_page" class="form-control" name="parameters[main_html]" placeholder="Insert main page content text">{{ $mainHtml }}</textarea>
</div>

@include('modules.admin.important_information')

@include('modules.admin.projects_donate')

@include('modules.admin.what_happens_so_far')

@include('modules.admin.we_still_need_support')
@php

    $page1 = '';
    $page2 = '';
    $page3 = '';

    if (isset($parameters['proj_rel_page_1'])) {
        $page1 = $parameters['proj_rel_page_1'];
    }
    if (isset($parameters['proj_rel_page_2'])) {
        $page2 = $parameters['proj_rel_page_2'];
    }
    if (isset($parameters['proj_rel_page_3'])) {
        $page3 = $parameters['proj_rel_page_3'];
    }

    $bgClass = "";

    if (isset($parameters['bg_class'])) {
        $bgClass = $parameters['bg_class'];
    }

@endphp

<h3 class="text-center">Related topics projects module:</h3>

<div class="form-group">
    <label>Background class:</label>
    <input class="form-control" name="parameters[bg_class]" placeholder="Example - bg-light" value="{{ $bgClass }}" />
</div>

<div class="form-group">
    <label>Topic id 1:</label>
    <input class="form-control" name="parameters[proj_rel_page_1]" placeholder="Insert topic id" value="{{ $page1 }}" />
</div>

<div class="form-group">
    <label>Topic id 2:</label>
    <input class="form-control" name="parameters[proj_rel_page_2]" placeholder="Insert topic id" value="{{ $page2 }}" />
</div>

<div class="form-group">
    <label>Topic id 3:</label>
    <input class="form-control" name="parameters[proj_rel_page_3]" placeholder="Insert topic id" value="{{ $page3 }}" />
</div>


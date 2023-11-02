@php

    $donateImg = '';
    $donateVideo = '';
    $widgetHtml = '';

    if (isset($parameters['donate_img'])) {
        $donateImg = $parameters['donate_img'];
    }

    if (isset($parameters['donate_video'])) {
        $donateVideo = $parameters['donate_video'];
    }

    if (isset($parameters['widget_html'])) {
        $widgetHtml = $parameters['widget_html'];
    }

@endphp

<h3 class="text-center">Project widget module:</h3>

<div class="form-group">
    <label>Widget module image:</label>
    <input class="form-control" name="parameters[donate_img]" placeholder="Insert widget img path"
        value="{{ $donateImg }}" />
</div>

<div class="form-group">
    <label>Widget module video:</label>
    <input class="form-control" name="parameters[donate_video]" placeholder="Insert widget video id"
        value="{{ $donateVideo }}" />
</div>

<div class="form-group">
    <label for="widget_html">Widget content:</label>
    <textarea wysiwyg-editor id="main_html" class="form-control" name="parameters[widget_html]"
        placeholder="Insert widget content here">{{ $widgetHtml }}</textarea>
</div>

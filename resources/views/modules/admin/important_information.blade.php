@php

    $importantInfoTitle = "";
    $importantInfo = "";
    $importantInfoLong = "";
    $bgClassImportant = "";

    if (isset($parameters['important_title'])) {
        $importantInfoTitle = $parameters['important_title'];
    }

    if (isset($parameters['important_text'])) {
        $importantInfo = $parameters['important_text'];
    }

    if (isset($parameters['important_text_long'])) {
        $importantInfoLong = $parameters['important_text_long'];
    }

    if (isset($parameters['bg_class_important'])) {
        $bgClassImportant = $parameters['bg_class_important'];
    }

@endphp

<h3 class="text-center">Important information module:</h3>

<div class="form-group">
    <label>Important info title</label>
    <input class="form-control" name="parameters[important_title]" placeholder="Insert important info title" value="{{ $importantInfoTitle }}" />
</div>

<div class="form-group">
    <label>Important info text</label>
    <textarea class="form-control" placeholder="Insert important info text" name="parameters[important_text]">{{ $importantInfo }}</textarea>
</div>

<div class="form-group">
    <label>Important info full text</label>
    <textarea class="form-control" placeholder="Insert important info text" name="parameters[important_text_long]">{{ $importantInfoLong }}</textarea>
</div>

<div class="form-group">
    <label>Background class:</label>
    <input class="form-control" name="parameters[bg_class_important]" placeholder="Example - bg-light" value="{{ $bgClassImportant }}" />
</div>

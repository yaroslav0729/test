@php
    $title = "";
    $textBefore = "";
    $textAfter = "";
    $imageBefore = "";
    $imageAfter = "";

    if (isset($parameters['subscribe_title'])) {
        $title = $parameters['subscribe_title'];
    }

    if (isset($parameters['subscribe_text_before'])) {
        $textBefore = $parameters['subscribe_text_before'];
    }

    if (isset($parameters['subscribe_text_after'])) {
        $textAfter = $parameters['subscribe_text_after'];
    }

    if (isset($parameters['subscribe_img_before'])) {
        $imageBefore = $parameters['subscribe_img_before'];
    }

    if (isset($parameters['subscribe_img_after'])) {
        $imageAfter = $parameters['subscribe_img_after'];
    }
@endphp
<h3 class="text-center">Join the cause module:</h3>
<div class="form-group">
    <label>Subscribe module title (JOIN THE CAUSE - by default):</label>
    <input class="form-control" name="parameters[subscribe_title]" placeholder="JOIN THE CAUSE" value="{{ $title }}" />
</div>

<div class="form-group">
    <label>Subscribe module - text before press plus button (There are so many ways to help, make sure you stay in the loop and sign up to our Newsletter! - by default)</label>
    <textarea class="form-control" name="parameters[subscribe_text_before]" placeholder="Insert subscribe text">{{ $textBefore }}</textarea>
</div>

<div class="form-group">
    <label>Subscribe module - text after press plus button (here are so many ways to help, make sure you stay in the loop and sign up to our Newsletter or find out more about our latest Mission Impossible Tour - by default)</label>
    <textarea class="form-control" name="parameters[subscribe_text_after]" placeholder="Insert subscribe text">{{ $textAfter }}</textarea>
</div>

<div class="form-group">
    <label>Subscribe module image before press plus button:</label>
    <input class="form-control" name="parameters[subscribe_img_before]" placeholder="Insert photo path" value="{{ $imageBefore }}" />
</div>

<div class="form-group">
    <label>Subscribe module image after press plus button:</label>
    <input class="form-control" name="parameters[subscribe_img_after]" placeholder="Insert photo path" value="{{ $imageAfter }}" />
</div>


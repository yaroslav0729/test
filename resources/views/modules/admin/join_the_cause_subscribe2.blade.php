@php
    $title = "";
    $text = "";
    $textMobile = "";
    $image = "";

    if (isset($parameters['subscribe_title'])) {
        $title = $parameters['subscribe_title'];
    }

    if (isset($parameters['subscribe_text'])) {
        $text = $parameters['subscribe_text'];
    }

    if (isset($parameters['subscribe_text_mobile'])) {
        $textMobile = $parameters['subscribe_text_mobile'];
    }

    if (isset($parameters['subscribe_img'])) {
        $image = $parameters['subscribe_img'];
    }
@endphp
<h3 class="text-center">Join the cause module-2:</h3>
<div class="form-group">
    <label>Subscribe module title (JOIN THE CAUSE - by default):</label>
    <input class="form-control" name="parameters[subscribe_title]" placeholder="JOIN THE CAUSE" value="{{ $title }}" />
</div>

<div class="form-group">
    <label>Subscribe module - text</label>
    <textarea class="form-control" name="parameters[subscribe_text]" placeholder="Insert subscribe text">{{ $text }}</textarea>
</div>

<div class="form-group">
    <label>Subscribe module - text (for Mobile)</label>
    <textarea class="form-control" name="parameters[subscribe_text_mobile]" placeholder="Insert subscribe for mobile text">{{ $textMobile }}</textarea>
</div>

<div class="form-group">
    <label>Subscribe module image:</label>
    <input class="form-control" name="parameters[subscribe_img]" placeholder="" value="{{ $image }}" />
</div>


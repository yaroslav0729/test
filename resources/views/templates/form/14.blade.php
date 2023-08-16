@php

$mainTitle = '';
$minsText = '';
$mainText = '';
$watchLink = '';
$video = '';
$videoPreview = '';

if (isset($parameters['main_title'])) {
    $mainTitle = $parameters['main_title'];
}

if (isset($parameters['mins_text'])) {
    $minsText = $parameters['mins_text'];
}

if (isset($parameters['main_text'])) {
    $mainText = $parameters['main_text'];
}

if (isset($parameters['watch_link'])) {
    $watchLink = $parameters['watch_link'];
}

if (isset($parameters['main_video'])) {
    $video = $parameters['main_video'];
}

if (isset($parameters['main_video_preview'])) {
    $videoPreview = $parameters['main_video_preview'];
}

@endphp

<div class="form-group">
    <label>Main title:</label>
    <input class="form-control" name="parameters[main_title]" placeholder="Insert title" value="{{ $mainTitle }}" />
</div>

<div class="form-group">
    <label>Mins text (90 ch):</label>
    <input class="form-control" name="parameters[mins_text]" placeholder="example: 7mins" value="{{ $minsText }}" />
</div>

<div class="form-group">
    <label>Main text (460 ch):</label>
    <textarea class="form-control" name="parameters[main_text]" placeholder="Insert text">{{ $mainText }}</textarea>
</div>

<div class="form-group">
    <label>Watch now link (90 ch):</label>
    <input class="form-control" name="parameters[watch_link]" placeholder="Insert link" value="{{ $watchLink }}" />
</div>

<div class="form-group">
    <label>Video link:</label>
    <input class="form-control" name="parameters[main_video]" placeholder="Insert video link"
        value="{{ $video }}" />
</div>

<div class="form-group">
    <label>Video preview:</label>
    <input class="form-control" name="parameters[main_video_preview]" placeholder="Insert path"
        value="{{ $videoPreview }}" />
</div>

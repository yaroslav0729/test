@php

$whoVideo = '';
$whoLink = '';
$whoVideoPreview = '';
$whoLinkText = '';
$whoTitle = '';
$whoText = '';

$infoBlock1 = '';
$infoBlock2 = '';
$infoBlock3 = '';

if (isset($parameters['who_we_are_video'])) {
    $whoVideo = $parameters['who_we_are_video'];
}

if (isset($parameters['who_we_are_video_preview'])) {
    $whoVideoPreview = $parameters['who_we_are_video_preview'];
}

if (isset($parameters['who_we_are_link'])) {
    $whoLink = $parameters['who_we_are_link'];
}

if (isset($parameters['who_we_are_link_text'])) {
    $whoLinkText = $parameters['who_we_are_link_text'];
}

if (isset($parameters['who_we_are_title'])) {
    $whoTitle = $parameters['who_we_are_title'];
}

if (isset($parameters['who_we_are_text'])) {
    $whoText = $parameters['who_we_are_text'];
}

if (isset($parameters['who_we_are_block_1_title'])) {
    $infoBlock1 = $parameters['who_we_are_block_1_title'];
}

if (isset($parameters['who_we_are_block_2_title'])) {
    $infoBlock2 = $parameters['who_we_are_block_2_title'];
}

if (isset($parameters['who_we_are_block_3_title'])) {
    $infoBlock3 = $parameters['who_we_are_block_3_title'];
}

$infoBlockText1 = '';
$infoBlockText2 = '';
$infoBlockText3 = '';

if (isset($parameters['who_we_are_block_1_text'])) {
    $infoBlockText1 = $parameters['who_we_are_block_1_text'];
}

if (isset($parameters['who_we_are_block_2_text'])) {
    $infoBlockText2 = $parameters['who_we_are_block_2_text'];
}

if (isset($parameters['who_we_are_block_3_text'])) {
    $infoBlockText3 = $parameters['who_we_are_block_3_text'];
}

@endphp

<h3 class="text-center">Who we are module:</h3>


<div class="form-group">
    <label>Who we are video:</label>
    <input class="form-control" required name="parameters[who_we_are_video]" placeholder="Who we are video"
        value="{{ $whoVideo }}" />
</div>

<div class="form-group">
    <label>Who we are video preview:</label>
    <input class="form-control" name="parameters[who_we_are_video_preview]" placeholder=""
        value="{{ $whoVideoPreview }}">
</div>

<div class="form-group ">
    <label>Who we are link:</label>
    <input class="form-control" required name="parameters[who_we_are_link]" placeholder="Who we are link"
        value="{{ $whoLink }}" />
</div>

<div class="form-group">
    <label>Who we are link text:</label>
    <input class="form-control" required name="parameters[who_we_are_link_text]" placeholder="Who we are link text"
        value="{{ $whoLinkText }}" maxlength="125" />
</div>

<div class="form-group">
    <label>Who we are title:</label>
    <input class="form-control" required name="parameters[who_we_are_title]" placeholder="Who we are title"
        value="{{ $whoTitle }}" />
</div>

<div class="form-group">
    <label>Who we are text:</label>
    <textarea class="form-control" required name="parameters[who_we_are_text]"
        placeholder="Insert Who we are text">{{ $whoText }}</textarea>
</div>

<div class="form-group">
    <label>Who we are block1 title:</label>
    <input class="form-control" type="text" name="parameters[who_we_are_block_1_title]" placeholder="Insert value"
        value="{{ $infoBlock1 }}" />
</div>

<div class="form-group">
    <label>Who we are block1 text:</label>
    <input class="form-control" type="text" name="parameters[who_we_are_block_1_text]" placeholder="Insert value"
        value="{{ $infoBlockText1 }}" />
</div>

<div class="form-group">
    <label>Who we are block2 title:</label>
    <input class="form-control" type="text" name="parameters[who_we_are_block_2_title]" placeholder="Insert value"
        value="{{ $infoBlock2 }}" />
</div>

<div class="form-group">
    <label>Who we are block2 text:</label>
    <input class="form-control" type="text" name="parameters[who_we_are_block_2_text]" placeholder="Insert value"
        value="{{ $infoBlockText2 }}" />
</div>

<div class="form-group">
    <label>Who we are block3 title:</label>
    <input class="form-control" type="text" name="parameters[who_we_are_block_3_title]" placeholder="Insert value"
        value="{{ $infoBlock3 }}" />
</div>

<div class="form-group">
    <label>Who we are block3 text:</label>
    <input class="form-control" type="text" name="parameters[who_we_are_block_3_text]" placeholder="Insert value"
        value="{{ $infoBlockText3 }}" />
</div>

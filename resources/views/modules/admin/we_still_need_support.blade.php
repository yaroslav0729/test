@php

$moduleTitle = "";

if (isset($parameters['still_need_title'])) {
    $moduleTitle = $parameters['still_need_title'];    
}

$digit1 = "";
$digit2 = "";
$digit3 = "";

if (isset($parameters['still_need_digit1'])) {
    $digit1 = $parameters['still_need_digit1'];    
}

if (isset($parameters['still_need_digit2'])) {
    $digit2 = $parameters['still_need_digit2'];    
}

if (isset($parameters['still_need_digit3'])) {
    $digit3 = $parameters['still_need_digit3'];    
}

$text1 = "";
$text2 = "";
$text3 = "";

if (isset($parameters['still_need_text1'])) {
    $text1 = $parameters['still_need_text1'];    
}

if (isset($parameters['still_need_text2'])) {
    $text2 = $parameters['still_need_text2'];    
}

if (isset($parameters['still_need_text3'])) {
    $text3 = $parameters['still_need_text3'];    
}

@endphp

<h3 class="text-center">We still need support module:</h3>

<div class="form-group">
    <label>Need support title:</label>
    <input class="form-control" name="parameters[still_need_title]" placeholder="Insert need support title" value="{{ $moduleTitle }}" />
</div>

<div class="form-group">
    <label>Need support digit1:</label>
    <input class="form-control" type="number" name="parameters[still_need_digit1]" placeholder="Insert value" value="{{ $digit1 }}" />
</div>

<div class="form-group">
    <label>Need support digit2:</label>
    <input class="form-control" type="number" name="parameters[still_need_digit2]" placeholder="Insert value" value="{{ $digit2 }}" />
</div>

<div class="form-group">
    <label>Need support digit3:</label>
    <input class="form-control" type="number" name="parameters[still_need_digit3]" placeholder="Insert value" value="{{ $digit3 }}" />
</div>

<div class="form-group">
    <label>Need support text1</label>
    <textarea class="form-control" name="parameters[still_need_text1]" placeholder="Insert need support  text1">{{ $text1 }}</textarea>
</div>

<div class="form-group">
    <label>Need support text2</label>
    <textarea class="form-control" name="parameters[still_need_text2]" placeholder="Insert need support  text2">{{ $text2 }}</textarea>
</div>

<div class="form-group">
    <label>Need support text3</label>
    <textarea class="form-control" name="parameters[still_need_text3]" placeholder="Insert need support  text3">{{ $text3 }}</textarea>
</div>
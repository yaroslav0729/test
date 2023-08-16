@php

$moduleTitle = "";

if (isset($parameters['still_need_title'])) {
    $moduleTitle = $parameters['still_need_title'];    
}

@endphp

<h3 class="text-center">We still need support module:</h3>

<div class="form-group">
    <label>Need support title:</label>
    <input class="form-control" name="parameters[still_need_title]" placeholder="Insert need support title" value="{{ $moduleTitle }}" />
</div>
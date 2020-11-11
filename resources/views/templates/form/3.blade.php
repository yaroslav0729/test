@php

$hdrType = "";
$whoVideo = "";
$whoLink = "";
$whoTitle = "";
$whoText = "";

if (isset($parameters['hdr_type'])) {
    $hdrType = $parameters['hdr_type'];    
}

if (isset($parameters['who_we_are_wideo'])) {
    $whoVideo = $parameters['who_we_are_wideo'];    
}

if (isset($parameters['who_we_are_link'])) {
    $whoLink = $parameters['who_we_are_link'];    
}

if (isset($parameters['who_we_are_title'])) {
    $whoTitle = $parameters['who_we_are_title'];    
}

if (isset($parameters['who_we_are_text'])) {
    $whoText = $parameters['who_we_are_text'];    
}

@endphp

<div class="form-group">
    <label>Header type</label>
    <select name="parameters[hdr_type]" class="form-control">
        @for ($i = 1; $i <= 5; $i++)
            <option value="{{ $i }}" @if((int)($hdrType) === $i) selected @endif>Type {{ $i }}</option>
        @endfor
    </select>
</div>

<div class="form-group">
    <label>Who we are video:</label>
    <input class="form-control" required name="parameters[who_we_are_wideo]" placeholder="Who we are video" value="{{ $whoVideo }}" />
</div>

<div class="form-group">
    <label>Who we are link:</label>
    <input class="form-control" required name="parameters[who_we_are_link]" placeholder="Who we are link" value="{{ $whoLink }}" />
</div>

<div class="form-group">
    <label>Who we are title:</label>
    <input class="form-control" required name="parameters[who_we_are_title]" placeholder="Who we are title" value="{{ $whoTitle }}" />
</div>

<div class="form-group">
    <label>Who we are text:</label>
    <textarea class="form-control" required name="parameters[who_we_are_text]" placeholder="Insert Who we are text">{{ $whoText }}</textarea>
</div>

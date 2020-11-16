@php

$hdrType = "";
$hdrTitle = "";
$hdrText = "";
$hdrLearnMoreLink = "";
$whoVideo = "";
$whoLink = "";
$whoLinkText = "";
$whoTitle = "";
$whoText = "";
$longtermLink = "";
$emergencyLink = "";
$volunteeringLink = "";
$sadiqahLink = "";


if (isset($parameters['hdr_type'])) {
    $hdrType = $parameters['hdr_type'];    
}

if (isset($parameters['hdr_title'])) {
    $hdrTitle = $parameters['hdr_title'];    
}

if (isset($parameters['hdr_text'])) {
    $hdrText = $parameters['hdr_text'];    
}

if (isset($parameters['hdr_learn_more'])) {
    $hdrLearnMoreLink = $parameters['hdr_learn_more'];    
}

if (isset($parameters['who_we_are_wideo'])) {
    $whoVideo = $parameters['who_we_are_wideo'];    
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

if (isset($parameters['our_work_longterm_link'])) {
    $longtermLink = $parameters['our_work_longterm_link'];    
}

if (isset($parameters['our_work_emergency_link'])) {
    $emergencyLink = $parameters['our_work_emergency_link'];    
}

if (isset($parameters['our_work_volunteering_link'])) {
    $volunteeringLink = $parameters['our_work_volunteering_link'];    
}

if (isset($parameters['our_work_sadiqah_link'])) {
    $sadiqahLink = $parameters['our_work_sadiqah_link'];    
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
    <label>Header title:</label>
    <input class="form-control" required name="parameters[hdr_title]" placeholder="Header title" value="{{ $hdrTitle }}" />
</div>

<div class="form-group">
    <label>Header text:</label>
    <input class="form-control" required name="parameters[hdr_text]" placeholder="Header text" value="{{ $hdrText }}" />
</div>

<div class="form-group">
    <label>Header learn more link:</label>
    <input class="form-control" required name="parameters[hdr_learn_more]" placeholder="Header learn more link" value="{{ $hdrLearnMoreLink }}" />
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
    <label>Who we are link text:</label>
    <input class="form-control" required name="parameters[who_we_are_link_text]" placeholder="Who we are link text" value="{{ $whoLinkText }}" />
</div>

<div class="form-group">
    <label>Who we are title:</label>
    <input class="form-control" required name="parameters[who_we_are_title]" placeholder="Who we are title" value="{{ $whoTitle }}" />
</div>

<div class="form-group">
    <label>Who we are text:</label>
    <textarea class="form-control" required name="parameters[who_we_are_text]" placeholder="Insert Who we are text">{{ $whoText }}</textarea>
</div>

<div class="form-group">
    <label>Our work Longterm projects link:</label>
    <input class="form-control" required name="parameters[our_work_longterm_link]" placeholder="Longterm projects" value="{{ $longtermLink }}" />
</div>

<div class="form-group">
    <label>Our work Emergency relief link:</label>
    <input class="form-control" required name="parameters[our_work_emergency_link]" placeholder="Emergency relief" value="{{ $emergencyLink }}" />
</div>

<div class="form-group">
    <label>Our work Volunteering link:</label>
    <input class="form-control" required name="parameters[our_work_volunteering_link]" placeholder="Who we are title" value="{{ $volunteeringLink }}" />
</div>

<div class="form-group">
    <label>Our work Sadiqah link:</label>
    <input class="form-control" required name="parameters[our_work_sadiqah_link]" placeholder="Who we are title" value="{{ $sadiqahLink }}" />
</div>

@include('modules.admin.related_pages', [
    'parameters' => $parameters
])

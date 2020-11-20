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

<section class="donate-today-card">
    <div class="wrap">
        <div class="title">
            @empty($moduleTitle)
            <span>We still need your support.</span>
            @else
            <span>{{ $moduleTitle }}</span>
            @endempty
        </div>
        <div class="list d-flex justify-content-center">
            <div class="item">
                <div>£<b>{{ $digit1 }}</b></div>
                {{ $text1 }}
            </div>
            <div class="item active-color-info">
                <div>£<b>{{ $digit2 }}</b></div>
                {{ $text1 }}
            </div>
            <div class="item active-color-danger">
                <div>£<b>{{ $digit3 }}</b></div>
                {{ $text1 }}
            </div>
        </div>
    </div>
</section>
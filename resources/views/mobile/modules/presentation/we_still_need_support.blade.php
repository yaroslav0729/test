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

        <div class="list donate-today-card-swiper" swiper-wrapper="we_still_need">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="item">
                            <div>£<b>{{ $digit1 }}</b></div>
                            {{ $text1 }}
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item active-color-info">
                            <div>£<b>{{ $digit2 }}</b></div>
                            {{ $text2 }}
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item active-color-danger">
                            <div>£<b>{{ $digit2 }}</b></div>
                            {{ $text3 }}
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

    </div>
</section>
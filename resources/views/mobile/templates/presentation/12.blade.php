@php

    $mainImg = "";
    
    if (isset($parameters['main_img'])) {
        $mainImg = $parameters['main_img'];    
    }
    
@endphp

<section class="head-mission-impossible">
    <div class="wrap" style="background-image: url({{ $mainImg }})">
        <div class="text">EMPOWER PEOPLE IN NEED</div>
        <div class="decor-text">
            <span class="text-red">Mission</span>
            <span>Possible</span>
        </div>
    </div>
</section>

<section class="pt-3 pb-3 pl-4 pr-4">
    <p class="font-size-16 mb-0"><b>THE NEXT STEP TO<br>VOLUNTEERING, MAKE IMPACTS<br>TO GLOBAL COMMUNITIES.</b></p>
</section>

<section class="swiper-mission-impossible" swiper-wrapper="mission_possible">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="img" style="background-image: url(img/content/swiper-mission-impossible.jpg)"></div>
            </div>
            <div class="swiper-slide">
                <div class="img" style="background-image: url(img/content/swiper-mission-impossible.jpg)"></div>
            </div>
            <div class="swiper-slide">
                <div class="img" style="background-image: url(img/content/swiper-mission-impossible.jpg)"></div>
            </div>
            <div class="swiper-slide">
                <div class="img" style="background-image: url(img/content/swiper-mission-impossible.jpg)"></div>
            </div>
            <div class="swiper-slide">
                <div class="img" style="background-image: url(img/content/swiper-mission-impossible.jpg)"></div>
            </div>
        </div>
    </div>
</section>


@include('modules.presentation.so_what_this_all')

@include('modules.presentation.how_does_it_work')

@include('modules.presentation.explore_past_missions')

@include('modules.presentation.experience_of_lifetime')

@include('modules.presentation.be_part_of_possible')

@include('modules.presentation.our_latest_mission')

@include('modules.presentation.related_pages')


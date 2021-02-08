@php

    $mainImg = "";
    
    if (isset($parameters['main_img'])) {
        $mainImg = $parameters['main_img'];    
    }
    
@endphp

<section class="head-mission-impossible bg-light">

    @empty($main_img)
    <div class="wrap" style="background-image: url(img/content/head-mission-impossible.jpg)">
    @else
    <div class="wrap" style="background-image: url({{ $mainImg }})">
    @endempty    
        
        <div class="text">EMPOWER PEOPLE IN NEED</div>
        <div class="decor-text">
            <span class="text-red">Mission</span>
            <span>Possible</span>
        </div>
    </div>
</section>

<section class="swiper-mission-impossible bg-light" swiper-wrapper="mission_possible" space-between="0" centered-slides="true" slides-per-view="auto">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="text text-uppercase"><span><b>1: </b>the next step to<br>volunteering, make impacts<br>to global communities.</span></div>
                <div class="img" style="background-image: url(img/content/swiper-mission-impossible.jpg)"></div>
            </div>
            <div class="swiper-slide">
                <div class="text text-uppercase"><span><b>2: </b>the next step to<br>volunteering, make impacts<br>to global communities.</span></div>
                <div class="img" style="background-image: url(img/content/swiper-mission-impossible.jpg)"></div>
            </div>
            <div class="swiper-slide">
                <div class="text text-uppercase"><span><b>3: </b>the next step to<br>volunteering, make impacts<br>to global communities.</span></div>
                <div class="img" style="background-image: url(img/content/swiper-mission-impossible.jpg)"></div>
            </div>
            <div class="swiper-slide">
                <div class="text text-uppercase"><span><b>4: </b>the next step to<br>volunteering, make impacts<br>to global communities.</span></div>
                <div class="img" style="background-image: url(img/content/swiper-mission-impossible.jpg)"></div>
            </div>
            <div class="swiper-slide">
                <div class="text text-uppercase"><span><b>5: </b>the next step to<br>volunteering, make impacts<br>to global communities.</span></div>
                <div class="img" style="background-image: url(img/content/swiper-mission-impossible.jpg)"></div>
            </div>
        </div>
    </div>
</section>

{{--<div class="pt-5 pb-5 bg-light"></div>--}}

@include('modules.presentation.so_what_this_all')

@include('modules.presentation.how_does_it_work')

@include('modules.presentation.explore_past_missions')

@include('modules.presentation.experience_of_lifetime')

@include('modules.presentation.be_part_of_possible')

@include('modules.presentation.our_latest_mission')

@include('modules.presentation.related_page_expanded')

<div class="pt-5 pb-5"></div>

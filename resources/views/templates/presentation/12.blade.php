@php

    $mainImg = "";

    if (isset($parameters['main_img'])) {
        $mainImg = $parameters['main_img'];
    }
    $deployment_date = "";

    if (isset($parameters['our_latest_text1'])) {
        $deployment_date = $parameters['our_latest_text1'];    
    }
@endphp

<section class="head-mission-impossible bg-light">

    @empty($main_img)
    <div class="wrap" style="background-image: url(img/content/head-mission-impossible.jpg)">
    @else
    <div class="wrap" style="background-image: url({{ $mainImg }})">
    @endempty

        <div class="text">
            <div>EMPOWERING PEOPLE IN NEED</div>
            <div class="">
                {{ $deployment_date }}
            </div>
        </div>
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
                <div class="text text-uppercase"><span><b>1: </b>MISSION POSSIBLE IS THE LIFE-CHANGING HUMANITARIAN EXPERIENCE</span></div>
                <div class="img" style="background-image: url(https://islamichelp.org.uk/storage/slider1%20missionpossible.jpeg)"></div>
            </div>
            <div class="swiper-slide">
                <div class="text text-uppercase"><span><b>2: </b>FROM CAMPAIGNING TO FUNDRAISING TO DEPLOYMENT AND DELIVERY</span></div>
                <div class="img" style="background-image: url(https://islamichelp.org.uk/storage/slider2%20missionpossible.jpeg)"></div>
            </div>
            <div class="swiper-slide">
                <div class="text text-uppercase"><span><b>3: </b>IT GIVES YOU THE FULL SPECTRUM OF THE HUMANITARIAN AID PROCESS</span></div>
                <div class="img" style="background-image: url(https://islamichelp.org.uk/storage/slider3%20mission%20possible.jpeg)"></div>
            </div>
            <div class="swiper-slide">
                <div class="text text-uppercase"><span><b>4: </b>YOU DIRECTLY DELIVER THE AID YOU HAVE RAISED THROUGH YOUR EFFORTS</span></div>
                <div class="img" style="background-image: url(https://islamichelp.org.uk/storage/slider4%20mission%20possible.jpeg)"></div>
            </div>
            <div class="swiper-slide">
                <div class="text text-uppercase"><span><b>5: </b>IT EMPOWERS THE COMMUNITIES YOU HELP, AND IT EMPOWERS YOU</span></div>
                <div class="img" style="background-image: url(https://islamichelp.org.uk/storage/slider%205%20mission%20possible.jpeg)"></div>
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

@include('modules.presentation.related_topics_project')

<div class="pt-5 pb-5"></div>

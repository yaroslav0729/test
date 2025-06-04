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

<section class="head-mission-impossible">
    <div class="wrap" style="background-image: url({{ $mainImg }})">
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

<div class="additional-content mt-4 text-center d-flex justify-content-center">
    <div class="mb-3">
        <img src="/storage/Screenshot 2025-06-03 at 15.14.36.jpg" 
            alt="Mission Possible Image" 
            class="img-fluid mb-3 zoomable-image" 
            style="max-width: 400px; width: 100%; border-radius: 10px; cursor: pointer; transition: transform 0.3s ease;" 
            id="missionImage"
        >
    </div>
</div>

@php
    $bePartLink = "";
    if (isset($parameters['be_part_link'])) {
        $bePartLink = $parameters['be_part_link'];    
    }
@endphp

<!-- Large Apply Now Section -->
<section class="apply-now-section text-center py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10">
                <a href="{{ $bePartLink }}" class="btn btn-outline-primary btn-lg px-4 py-3" style="font-size: 1.2rem; font-weight: bold; border-width: 2px; min-width: 180px; width: 100%;">
                    APPLY NOW
                </a>
            </div>
        </div>
    </div>
</section>

<section class="pt-4 pb-4 pl-5 pr-5">
    <p class="font-size-16 mb-0"><b>THE NEXT STEP TO<br>VOLUNTEERING, MAKE IMPACTS<br>TO GLOBAL COMMUNITIES.</b></p>
</section>

<section class="swiper-mission-impossible" swiper-wrapper="mission_possible" space-between="0" centered-slides="true" slides-per-view="1">
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

@include('modules.presentation.so_what_this_all')

@include('modules.presentation.how_does_it_work')

@include('modules.presentation.explore_past_missions')

@include('modules.presentation.experience_of_lifetime')

@include('modules.presentation.be_part_of_possible')

@include('modules.presentation.our_latest_mission')

@include('modules.presentation.related_topics_project')

<style>
/* Apply Now Button Hover Effect */
.btn-outline-primary:hover {
    background-color: #007bff !important;
    border-color: #007bff !important;
    color: white !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 8px 20px rgba(0,123,255,0.3) !important;
    transition: all 0.3s ease !important;
}
</style>


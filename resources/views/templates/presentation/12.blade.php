@php

    $mainImg = "";
    $soWhatImg = "";
    $latestMissionText = "";
    $latestMissionDate = "";
    $applyNowLink = "";
    
    if (isset($parameters['main_img'])) {
        $mainImg = $parameters['main_img'];    
    }

    if (isset($parameters['so_what_img'])) {
        $soWhatImg = $parameters['so_what_img'];    
    }

    if (isset($parameters['latest_mission_text'])) {
        $latestMissionText = $parameters['latest_mission_text'];    
    }

    if (isset($parameters['latest_mission_date'])) {
        $latestMissionDate = $parameters['latest_mission_date'];    
    }

    if (isset($parameters['apply_now_link'])) {
        $applyNowLink = $parameters['apply_now_link'];    
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

<section class="swiper-mission-impossible bg-light">
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

<div class="pt-5 pb-5 bg-light"></div>


<section class="so-all-about bg-light">
    <div class="red-line"></div>
    <div class="title">
        <p>So what's this  all about?</p>
        <i class="moon-icons-arrow-down"></i>
    </div>
    <div class="row gutter-0 mb-4">
        <div class="col-6">
            @empty($soWhatImg)
            <img src="img/content/so-all-about.jpg" alt="" class="w-100">
            @else
            <img src="{{ $soWhatImg }}" alt="" class="w-100"> 
            @endempty
        </div>
        <div class="col-6 bg-red pl-5 pr-5 d-flex align-items-center">
            <div>
                <p class="font-size-16 text-white  pl-5 pr-5">Mission Possible is our flagship volunteering programme and the humanitarian experience of a lifetime. A life-changing venture for volunteers and beneficiaries, it gives young people the opportunity to experience day-to-day humanitarian work on the ground.</p>
                <p class="font-size-16 text-white  pl-5 pr-5 mb-0">As well as directly delivering aid, volunteers encounter the daily heart-breaking realities that face aid workers, including interviewing potential beneficiaries and deciding – based on needs criteria – certain aid allocations.</p>
            </div>
        </div>
    </div>
    <div class="pt-3"></div>
    <div class="box bg-red">
        <div class="row align-items-center">
            <div class="col-8">
                <p class="text-white font-size-20 text-uppercase mb-0">
                    <b>Latest mission | 
                        @empty($latestMissionText)
                        Tanzania 
                        @else
                        {{ $latestMissionText }}
                        @endempty

                        @empty($latestMissionDate)
                        2oth August 2020 
                        @else
                        {{ $latestMissionDate }}
                        @endempty
                    </b>
                </p>
            </div>
            <div class="col-4 text-right">
                <a href="{{ $applyNowLink }}" class="btn btn-outline-primary border-white">Apply now</a>
            </div>
        </div>
    </div>
</section>

@include('modules.presentation.how_does_it_work')

@include('modules.presentation.explore_past_missions')

@include('modules.presentation.experience_of_lifetime')

@include('modules.presentation.be_part_of_possible')

@include('modules.presentation.our_latest_mission')

@include('modules.presentation.related_pages')

<div class="pt-5 pb-5"></div>

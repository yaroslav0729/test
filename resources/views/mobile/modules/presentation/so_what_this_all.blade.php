@php

    $soWhatImg = "";
    $latestMissionText  = "";
    $latestMissionDate = "";
    $applyNowLink = "";
    $soWhatText = "";

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

    if (isset($parameters['so_what_text'])) {
        $soWhatText = $parameters['so_what_text'];    
    }
    
@endphp

<section class="so-all-about bg-light">
    <div class="red-line"></div>
    <div class="title">
        <p>So what's this  all about?</p>
    </div>
    <div class="bg-red p-4">
        <p class="font-size-16 text-white mb-0">
            {{ $soWhatText }}
        </p>
    </div>

    <img src="{{ $soWhatImg }}" alt="" class="w-100">

    <div class="help-info-swiper" swiper-wrapper="so_what_all_this_about_">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <span>8.2k</span>
                    <span>Meals provided</span>
                </div>
                <div class="swiper-slide">
                    <span>10.1k</span>
                    <span>Children educated</span>
                </div>
                <div class="swiper-slide">
                    <span>6.6k</span>
                    <span>People empowered</span>
                </div>
                <div class="swiper-slide">
                    <span>8k</span>
                    <span>Wells built</span>
                </div>
            </div>
            <div class="swiper-button-next"><i class="moon-icons-arrow-right"></i></div>
            <div class="swiper-button-prev"><i class="moon-icons-arrow-left"></i></div>
        </div>
    </div>

    <div class="pt-3"></div>
    <div class="pl-4 pr-4">
        <div class="box bg-red text-center">
            <p class="text-white font-size-12 text-uppercase mb-4"><b>Latest mission</b></p>
            <p class="text-white font-size-30 font-weight-light text-uppercase mb-0">
                @empty($latestMissionText)
                Tanzania 
                @else
                {{ $latestMissionText }}
                @endempty
            </p>
            <p class="text-white font-size-16 text-uppercase mb-4">
                <b>
                    @empty($latestMissionDate)
                    2oth August 2020 
                    @else
                    {{ $latestMissionDate }}
                    @endempty
                </b>
            </p>
            <a href="{{ $applyNowLink }}" class="btn btn-outline-primary border-white">Apply now</a>
        </div>
    </div>
</section>
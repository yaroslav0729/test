@php

    $soWhatImg = "";
    $latestMissionText  = "";
    $latestMissionDate = "";
    $applyNowLink = "";

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
@php

    $mainTitle = "";
    $startLink = "";
    $colTitle1 = "";
    $colText1 = "";
    $colTitle2 = "";
    $colText2 = "";
    $colTitle3 = "";
    $colText3 = "";
    $howDoText = "";
    $findMissionText = "";

    if (isset($parameters['main_title'])) {
        $mainTitle = $parameters['main_title'];
        $mainTitle = str_replace('|', '<br>', $mainTitle);
    }

    if (isset($parameters['start_link'])) {
        $startLink = $parameters['start_link'];    
    }

    if (isset($parameters['col_title1'])) {
        $colTitle1 = $parameters['col_title1'];    
    }

    if (isset($parameters['col_text1'])) {
        $colText1 = $parameters['col_text1'];    
    }

    if (isset($parameters['col_title1'])) {
        $colTitle2 = $parameters['col_title1'];    
    }

    if (isset($parameters['col_text2'])) {
        $colText2 = $parameters['col_text2'];    
    }

    if (isset($parameters['col_title3'])) {
        $colTitle3 = $parameters['col_title3'];    
    }

    if (isset($parameters['col_text3'])) {
        $colText3 = $parameters['col_text3'];    
    }

    if (isset($parameters['how_do_text'])) {
        $howDoText = $parameters['how_do_text'];    
    }

    if (isset($parameters['find_mission'])) {
        $findMissionText = $parameters['find_mission'];    
    }

@endphp

<section class="head-Volunteer">
    <!--step 1-->
    <h1>{!! $mainTitle !!}</h1>
    <a href="{{ $startLink }}"><button class="btn btn-outline-primary btn-black">Start</button></a>
</section>

<section class="how-does-work with-lines pt-4">
    <div class="title">
        <p>{{ $howDoText }}</p>
        <span>{{ $findMissionText }}</span>
    </div>
    <div class="item">
        <img src="img/ico-apply-online.svg" alt="">
        <div class="num">01</div>
        <div>{{ $colTitle1 }}</div>
        <p>{{ $colText1 }}</p>
    </div>
    <div class="item">
        <img src="img/ico-email.svg" alt="">
        <div class="num">02</div>
        <div>{{ $colTitle2 }}</div>
        <p>{{ $colText2 }}</p>
    </div>
    <div class="item pl-0 pl-md-5">
        <img src="img/ico-post.svg" alt="">
        <div class="num">03</div>
        <div>{{ $colTitle3 }}</div>
        <p>{{ $colText3 }}</p>
    </div>
</section>



<div class="pt-4 pb-3"></div>

@include('modules.presentation.related_pages')
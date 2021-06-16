@php

    $whoVideo = "";
    $whoLink = "";
    $whoLinkText = "";
    $whoTitle = "";
    $whoText = "";

    $infoBlock1 = "";
    $infoBlock2 = "";
    $infoBlock3 = "";

    if (isset($parameters['who_we_are_video'])) {
        $whoVideo = $parameters['who_we_are_video'];
    }

    if (isset($parameters['who_we_are_video'])) {
        $whoVideo = $parameters['who_we_are_video'];
    }

    if (isset($parameters['who_we_are_link'])) {
        $whoLink = $parameters['who_we_are_link'];
    }

    if (isset($parameters['who_we_are_link_text'])) {
        $whoLinkText = $parameters['who_we_are_link_text'];
    }

    if (isset($parameters['who_we_are_title'])) {
        $whoTitle = $parameters['who_we_are_title'];
    }

    if (isset($parameters['who_we_are_text'])) {
        $whoText = $parameters['who_we_are_text'];
    }

    if (isset($parameters['who_we_are_block_1_title'])) {
        $infoBlock1 = $parameters['who_we_are_block_1_title'];    
    }

    if (isset($parameters['who_we_are_block_2_title'])) {
        $infoBlock2 = $parameters['who_we_are_block_2_title'];    
    }

    if (isset($parameters['who_we_are_block_3_title'])) {
        $infoBlock3 = $parameters['who_we_are_block_3_title'];    
    }

    $infoBlockText1 = "";
    $infoBlockText2 = "";
    $infoBlockText3 = "";

    if (isset($parameters['who_we_are_block_1_text'])) {
        $infoBlockText1 = $parameters['who_we_are_block_1_text'];    
    }

    if (isset($parameters['who_we_are_block_2_text'])) {
        $infoBlockText2 = $parameters['who_we_are_block_2_text'];    
    }

    if (isset($parameters['who_we_are_block_3_text'])) {
        $infoBlockText3 = $parameters['who_we_are_block_3_text'];    
    }

@endphp

<div class="wrap">
    <section class="who-we-are">
        <div class="row gutter-0">
            <div class="col-6">
                <div class="img-video play-tr videoWrapper" style="">
                    <iframe width="1280" height="720" src="https://www.youtube.com/embed/{{ $whoVideo }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-6">
                <div class="text">
                    <div class="title-container">
                        <a href="{{ $whoLink }}" class="text-underline text-dark letter-spacing-1"><b>{{ $whoLinkText }}</b></a>
                    </div>
                    <p class="text-title-container font-size-30 pr-2"><b>{!! $whoTitle !!}</b></p>
                    <div class="pr-5">
                        <p class="font-size-16 pr-5">{!! $whoText !!}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="help-info">
            <div>
                <span>{{ $infoBlock1 }}</span>
                <span>{{ $infoBlockText1 }}</span>
            </div>
            <div>
                <span>{{ $infoBlock2 }}</span>
                <span>{{ $infoBlockText2 }}</span>
            </div>
            <div>
                <span>{{ $infoBlock3 }}</span>
                <span>{{ $infoBlockText3 }}</span>
            </div>
        </div>
    </section>
</div>
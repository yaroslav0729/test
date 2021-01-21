@php

    $moduleTitle = "";
    $moduleText = "";

    if (isset($parameters['what_happens_title'])) {
        $moduleTitle = $parameters['what_happens_title'];    
    }

    if (isset($parameters['what_happens_text'])) {
        $moduleText = $parameters['what_happens_text'];    
    }

    $infoBlock1 = "";
    $infoBlock2 = "";
    $infoBlock3 = "";

    if (isset($parameters['what_happens_block1_title'])) {
        $infoBlock1 = $parameters['what_happens_block1_title'];    
    }

    if (isset($parameters['what_happens_block2_title'])) {
        $infoBlock2 = $parameters['what_happens_block2_title'];    
    }

    if (isset($parameters['what_happens_block3_title'])) {
        $infoBlock3 = $parameters['what_happens_block3_title'];    
    }

    $infoBlockText1 = "";
    $infoBlockText2 = "";
    $infoBlockText3 = "";

    if (isset($parameters['what_happens_block1_text'])) {
        $infoBlockText1 = $parameters['what_happens_block1_text'];    
    }

    if (isset($parameters['what_happens_block2_text'])) {
        $infoBlockText2 = $parameters['what_happens_block2_text'];    
    }

    if (isset($parameters['what_happens_block3_text'])) {
        $infoBlockText3 = $parameters['what_happens_block3_text'];    
    }

    $bgImage = "";

    if (isset($parameters['what_happens_img'])) {
        $bgImage = $parameters['what_happens_img'];    
    }

@endphp

<section class="whats-happened-far">
    <p style="padding-left: 30px;" class="font-size-12 mb-4 pb-2"><b>ISLAMIC HELP'S RESULTS</b></p>
    <div class="black-line"></div>
    <div class="body">
        @empty($moduleTitle)
        <div class="tl">What's happened so far.</div>
        @else
        <div class="tl">{{ $moduleTitle }}</div> 
        @endempty

        <div class="text bg-info">
            @empty($moduleText)
            <p>180 Characters perspiciais und omnis iste natus error sit volup tatem accusantium dis doloremque laudantium, totam annum rem aperiam, eaque ipsa quae ab illomsi inventore veritatis.</p>
            @else 
            <p>{{ $moduleText }}</p>
            @endisset
        </div>

        @empty($bgImage)
        <img src="img/content/project-2.jpg" alt="" class="w-100">
        @else
        <img src="{{ $bgImage }}" alt="" class="w-100">
        @endempty

        <div class="help-info-swiper" swiper-wrapper="what_happens">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <span>{{ $infoBlock1 }}</span>
                        <span>{{ $infoBlockText1 }}</span>
                    </div>
                    <div class="swiper-slide">
                        <span>{{ $infoBlock2 }}</span>
                        <span>{{ $infoBlockText2 }}</span>
                    </div>
                    <div class="swiper-slide">
                        <span>{{ $infoBlock3 }}</span>
                        <span>{{ $infoBlockText3 }}</span>
                    </div>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"><i class="moon-icons-arrow-right"></i></div>
            </div>
        </div>
    </div>
</section>
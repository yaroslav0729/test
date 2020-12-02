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

    if (!isset($isEmergency)) $isEmergency = false;

@endphp

<section class="whats-happened-far">
    <p style="padding-left: 90px;" class="font-size-12 mb-4"><b>ISLAMIC HELP'S RESULTS</b></p>
    <div class="black-line"></div>
    <div class="body">
        <div class="row gutter-0">
            <div class="col-7" style="z-index: 2">
                @empty($moduleTitle)
                <div class="tl">What's happened so far.</div>
                @else 
                <div class="tl">{{ $moduleTitle }}</div>
                @endisset

                <div class="text @if($isEmergency) bg-dark @else bg-info @endif">
                    @empty($moduleText)
                    <p>180 Characters perspiciais und omnis iste natus error sit volup tatem accusantium dis doloremque laudantium, totam annum rem aperiam, eaque ipsa quae ab illomsi inventore veritatis.</p>
                    @else 
                    <p>{{ $moduleText }}</p>
                    @endisset
                    <div class="info">
                        <div class="bg @if($isEmergency) bg-danger @else bg-danger-light @endif"></div>
                        <div class="rectangle @if($isEmergency) bg-warning @else bg-danger @endif"></div>
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
                    </div>
                </div>
            </div>
            <div class="col-5">
                @empty($bgImage)
                <img src="img/content/project-2.jpg" alt="">
                @else
                <img src="{{ $bgImage }}" alt="">
                @endempty
            </div>
        </div>
    </div>
</section>
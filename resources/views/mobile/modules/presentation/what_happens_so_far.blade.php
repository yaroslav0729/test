@php

    $moduleTitle = "";
    $moduleText = "";

    if (isset($parameters['what_happens_title'])) {
        $moduleTitle = $parameters['what_happens_title'];    
    }

    if (isset($parameters['what_happens_text'])) {
        $moduleText = $parameters['what_happens_text'];    
    }

    $peopleHelped = "";
    $countries = "";
    $volunteers = "";

    if (isset($parameters['what_happens_people_helped'])) {
        $peopleHelped = $parameters['what_happens_people_helped'];    
    }

    if (isset($parameters['what_happens_countries'])) {
        $countries = $parameters['what_happens_countries'];    
    }

    if (isset($parameters['what_happens_volunteers'])) {
        $volunteers = $parameters['what_happens_volunteers'];    
    }

@endphp

<section class="whats-happened-far">
    <p style="padding-left: 30px;" class="font-size-12 mb-4"><b>ISLAMIC HELP'S RESULTS</b></p>
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
        <img src="img/content/project-2.jpg" alt="" class="w-100">
        <div class="help-info-swiper">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <span>{{ $peopleHelped }}k</span>
                        <span>People helped</span>
                    </div>
                    <div class="swiper-slide">
                        <span>{{ $countries }}</span>
                        <span>Countries</span>
                    </div>
                    <div class="swiper-slide">
                        <span>{{ $volunteers }}</span>
                        <span>Volunteers this year</span>
                    </div>
                </div>
                <div class="swiper-button-next"><i class="far fa-arrow-right"></i></div>
                <div class="swiper-button-prev"><i class="far fa-arrow-left"></i></div>
            </div>

            <script>
                var swiper = new Swiper('.help-info-swiper .swiper-container', {
                    navigation: {
                        nextEl: '.help-info-swiper .swiper-button-next',
                        prevEl: '.help-info-swiper .swiper-button-prev',
                    },
                });
            </script>
        </div>
    </div>
</section>
@php

    $whoVideo = "";
    $whoLink = "";
    $whoLinkText = "";
    $whoTitle = "";
    $whoText = "";
    $longtermLink = "";
    $emergencyLink = "";
    $volunteeringLink = "";
    $sadiqahLink = "";
    $relatedPages = [];
    $hdrTypeActive = [];
    $hdrColorType = "";
    $hdrLinkText = [];
    $hdrLearnMoreLink = [];
    $hdrTitle = [];
    $hdrText = [];
    $hdrBgImage = [];

    for ($i=1; $i<=4; $i++) {
        $hdrTypeActive[$i] = "";
        $hdrLinkText[$i] = "";
        $hdrLearnMoreLink[$i] = "";
        $hdrTitle[$i] = "";
        $hdrText[$i] = "";
        $hdrBgImage[$i] = "";
    }

    if (isset($parameters['hdr_color_type'])) {
        $hdrColorType = $parameters['hdr_color_type'];
    }

    $hdrTypeValue = $hdrColorType === 'blue' ? 1 : 2;


    for ($i=1; $i<=4; $i++){
        if (isset($parameters['hdr_type_active_' . $i])) {
            $hdrTypeActive[$i] = $parameters['hdr_type_active_' . $i];
        }
        if (isset($parameters['hdr_link_text_' . $i])) {
            $hdrLinkText[$i] = $parameters['hdr_link_text_' . $i];
        }
        if (isset($parameters['hdr_learn_more_link_' .$i])) {
            $hdrLearnMoreLink[$i] = $parameters['hdr_learn_more_link_' . $i];
        }
        if (isset($parameters['hdr_title_' .$i])) {
            $hdrTitle[$i] = $parameters['hdr_title_' . $i];
        }
        if (isset($parameters['hdr_text_' .$i])) {
            $hdrText[$i] = $parameters['hdr_text_' . $i];
        }
        if (isset($parameters['hdr_bg_image_' .$i])) {
            $hdrBgImage[$i] = $parameters['hdr_bg_image_' . $i];
        }
    }


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

    if (isset($parameters['our_work_longterm_link'])) {
        $longtermLink = $parameters['our_work_longterm_link'];
    }

    if (isset($parameters['our_work_emergency_link'])) {
        $emergencyLink = $parameters['our_work_emergency_link'];
    }

    if (isset($parameters['our_work_volunteering_link'])) {
        $volunteeringLink = $parameters['our_work_volunteering_link'];
    }

    if (isset($parameters['our_work_sadiqah_link'])) {
        $sadiqahLink = $parameters['our_work_sadiqah_link'];
    }

@endphp

@empty(!$hdrTypeActive)

<section class="main-page-header style-{{ $hdrTypeValue }}" swiper-wrapper="header2" style="display: none1">
        <div class="wrap">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @for ($i = 1; $i <= 4; $i++)
                        @if(in_array($i, $hdrTypeActive ))
                            <div class="swiper-slide">
                                <div class="body">
                                    <div class="left">
                                        <div class="mb-4">
                                            <a href="{{ $hdrLearnMoreLink[$i] }}"
                                               class="learn-more text-underline text-dark"><b>{{ $hdrLinkText[$i] }}</b></a>
                                        </div>
                                        <div class="title mb-3">
                                            @if($hdrColorType === 'blue')
                                                {!! \App\Helpers\StrHelper::addSpanWithClass($hdrTitle[$i], 'text-info') !!}
                                            @else
                                                {!! \App\Helpers\StrHelper::addSpanWithClass($hdrTitle[$i], 'text-danger') !!}
                                            @endif
                                        </div>
                                        <p class="mb-5">{!! $hdrText[$i] !!}</p>
                                        <a href="#"
                                           class="btn @if($hdrColorType === 'blue') btn-info @else btn-danger @endif">Donate
                                            now</a>
                                    </div>
                                    <a href="{{ $hdrLearnMoreLink[$i] }}" class="right"
                                         style="background-image: url('{{ $hdrBgImage[$i] }}')"></a>
                                    <a href="#" class="view-more swiper-button-next"><i class="moon-icons-arrow-right"></i></a>
                                </div>
                            </div>
                        @endif
                    @endfor
                </div>
            </div>
        </div>
    </section>

@endempty

@include('modules.presentation.quick_donation')

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
                    <div class="mb-4">
                        <a href="{{ $whoLink }}" class="text-underline text-dark"><b>{{ $whoLinkText }}</b></a>
                    </div>
                    <p class="font-size-30 mb-2"><b>{!! $whoTitle !!}</b></p>
                    <div class="pr-5">
                        <p class="font-size-16 pr-5">{!! $whoText !!}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="help-info">
            <div>
                <span>8k</span>
                <span>People helped</span>
            </div>
            <div>
                <span>36</span>
                <span>Countries</span>
            </div>
            <div>
                <span>1'407</span>
                <span>Volunteers this year</span>
            </div>
        </div>
    </section>
</div>

<section class="our-work">
    <div class="wrap">
        <div class="mb-4">
            <a href="#" class="text-underline text-dark view-more"><b>OUR WORK</b></a>
        </div>
        <div class="row">
            <div class="col-3">
                <a href="{{ $longtermLink }}">
                    <span style="background-image: url(img/ico-leaf.svg)"></span>
                    <p>Longterm Projects</p>
                </a>
            </div>
            <div class="col-3">
                <a href="{{ $emergencyLink }}">
                    <span style="background-image: url(img/ico-alert.svg)"></span>
                    <p>Emergency Relief</p>
                </a>
            </div>
            <div class="col-3">
                <a href="{{ $volunteeringLink }}">
                    <span style="background-image: url(img/ico-motivation.svg)"></span>
                    <p>Volunteering</p>
                </a>
            </div>
            <div class="col-3">
                <a href="{{ $sadiqahLink }}">
                    <span style="background-image: url(img/ico-Saadiqah.svg)"></span>
                    <p>Sadiqah</p>
                </a>
            </div>
        </div>
    </div>
</section>

@include('modules.presentation.current_projects')

@include('modules.presentation.latest_projects')

@include('modules.presentation.lets_join')

<section class="widget-about-project">
    <div class="row gutter-0">
        <div class="col-6"><a href="#" class="view-more text-underline">VIEW ALL PROJECTS <i
                    class="moon-icons-arrow-up"></i></a></div>
    </div>
    <div class="row gutter-0">
        <div class="col-6 img" style="background-image: url(img/content/widget-about-project-1.jpg)"></div>
        <div class="col-6 descr d-flex align-items-center">
            <div>
                <p class="font-size-30 text-uppercase" style="font-weight: 100"><b>help orphans</b> & the environment
                </p>
                <p class="font-size-16" style="font-weight: 700">Critical campaign info, 60 ch. lorem ipsum dolor sit
                    ametas.</p>
                <a href="#" class="text-underline ">LEARN MORE</a>
            </div>
        </div>
    </div>
</section>

<section class="whats-new">
    <div class="wrap">
        <div class="title">
            <svg class="decor-wave d-inline-block" version="1.0" xmlns="http://www.w3.org/2000/svg"
                 width="2202.000000pt" height="166.000000pt" viewBox="0 0 2202.000000 166.000000"
                 preserveAspectRatio="xMidYMid meet">
                <g transform="translate(0.000000,166.000000) scale(0.100000,-0.100000)"
                   fill="#000000" stroke="none">
                    <path d="M170 1630 c-53 -25 -92 -60 -129 -115 -23 -36 -26 -49 -26 -135 0
    -86 3 -99 26 -135 63 -94 129 -129 263 -139 246 -18 368 -100 648 -439 168
    -205 344 -382 451 -455 104 -71 240 -135 362 -168 94 -26 113 -28 300 -28 185
    0 207 2 298 27 125 33 278 107 389 187 94 67 262 234 368 365 185 230 310 359
    408 422 110 71 265 102 410 83 214 -28 326 -112 617 -465 242 -293 370 -407
    565 -505 189 -94 285 -115 525 -115 166 1 201 4 279 24 304 79 510 233 807
    601 51 63 147 169 213 236 182 183 281 228 491 227 129 -1 214 -22 301 -74 78
    -47 212 -176 329 -316 55 -65 130 -155 168 -201 205 -244 435 -402 687 -470
    87 -24 111 -26 295 -26 185 0 207 2 298 27 117 31 284 109 375 174 108 77 238
    207 407 408 315 374 410 446 627 475 62 8 106 8 166 0 230 -31 328 -108 679
    -536 106 -129 268 -285 366 -352 104 -72 245 -137 364 -169 91 -25 113 -27
    298 -27 187 0 207 2 300 27 55 15 150 52 210 82 198 97 331 216 585 520 168
    202 298 332 385 383 113 66 252 92 394 72 214 -29 327 -114 616 -465 242 -293
    370 -407 565 -505 189 -94 285 -115 525 -115 209 1 288 14 439 76 224 93 376
    221 639 539 231 278 377 408 501 445 96 29 198 38 293 25 213 -28 324 -112
    620 -468 239 -288 369 -404 558 -499 177 -89 272 -113 480 -120 121 -4 182 -1
    250 11 313 54 570 224 835 552 113 140 249 291 319 356 128 117 229 161 405
    174 62 5 107 14 141 30 63 29 73 38 116 99 33 48 34 53 34 145 0 86 -2 99 -27
    137 -38 59 -65 82 -127 111 -51 24 -60 24 -185 19 -179 -8 -285 -36 -451 -120
    -191 -95 -320 -212 -560 -502 -291 -353 -403 -437 -619 -465 -94 -13 -197 -4
    -292 25 -125 37 -258 156 -500 445 -268 322 -416 446 -640 539 -153 62 -230
    75 -444 76 -170 0 -206 -3 -279 -23 -186 -49 -334 -127 -490 -257 -93 -78
    -153 -142 -339 -366 -268 -324 -387 -412 -595 -439 -95 -13 -197 -4 -294 25
    -115 34 -264 163 -457 395 -43 52 -110 132 -148 178 -206 242 -423 389 -673
    458 -94 26 -113 28 -300 28 -185 0 -207 -2 -298 -27 -118 -31 -280 -107 -374
    -173 -106 -75 -252 -223 -411 -414 -298 -359 -408 -441 -626 -470 -94 -13
    -210 -1 -300 30 -127 43 -249 152 -466 415 -312 378 -519 535 -807 612 -91 25
    -113 27 -298 27 -187 0 -206 -2 -300 -28 -122 -33 -258 -97 -362 -168 -107
    -73 -283 -250 -451 -455 -159 -192 -276 -307 -372 -363 -143 -85 -342 -100
    -521 -40 -132 45 -239 142 -486 439 -177 212 -270 307 -383 391 -108 80 -276
    162 -405 197 -93 26 -113 28 -295 28 -214 -1 -292 -14 -442 -76 -224 -92 -374
    -217 -638 -534 -336 -403 -451 -479 -715 -478 -264 2 -395 95 -745 528 -103
    127 -237 261 -329 331 -111 83 -280 166 -406 201 -93 25 -114 27 -300 27 -185
    0 -207 -2 -298 -27 -119 -32 -260 -97 -364 -169 -115 -79 -255 -219 -444 -444
    -287 -343 -383 -414 -601 -444 -94 -13 -211 -1 -302 30 -124 42 -250 154 -466
    415 -253 306 -401 438 -596 532 -152 73 -274 103 -439 109 -117 5 -134 3 -175
    -16z"/>
                </g>
            </svg>
            <b>WHAT'S NEW <i class="moon-icons-arrow-right"></i></b> <a href="#" class="text-underline text-uppercase letter-spacing-1"><b>visit newsroom</b></a>
        </div>
        <div>
            <div class="row gutter-5">
                <div class="col-12 col-lg-12 col-xl-6">
                    <div class="item vertical">
                        <a class="img" href="#">
                            <span style="background-image: url(img/content/whats-new-1.jpg)"></span>
                            <span class="plus bg-info"><i class="moon-icons-plus"></i></span>
                        </a>
                        <div class="descr">
                            <p class="font-size-20 letter-spacing-1 mb-0"><b>Article Video placement 30ch</b></p>
                            <p class="font-size-16 mb-4 letter-spacing-0">Subtitle capture copy placed here, 40ch...</p>
                            <div class="date">April 06, 2020 BY AHMED SALEM</div>
                            <div class="stat"><span>1.2k</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-12 col-xl-6">
                    <div class="item">
                        <a class="img" href="#">
                        <span style="background-image: url(img/content/whats-new-2.jpg)">
                            <i class="fas fa-play-circle"></i>
                        </span>
                            <span class="plus bg-danger"><i class="moon-icons-plus"></i></span>
                        </a>
                        <div class="descr">
                            <p class="font-size-20 letter-spacing-1 mb-0"><b>Article Video placement 30ch</b></p>
                            <p class="font-size-16 mb-4 letter-spacing-0">Subtitle capture copy placed here, 40ch...</p>
                            <div class="date">April 06, 2020 BY AHMED SALEM</div>
                        </div>
                    </div>
                    <div class="item">
                        <a class="img" href="#">
                            <span style="background-image: url(img/content/whats-new-3.jpg)"></span>
                            <span class="plus bg-warning"><i class="moon-icons-plus"></i></span>
                        </a>
                        <div class="descr">
                            <p class="font-size-20 letter-spacing-1 mb-0"><b>Article Video placement 30ch</b></p>
                            <p class="font-size-16 mb-4 letter-spacing-0">Subtitle capture copy placed here, 40ch...</p>
                            <div class="date">April 06, 2020 BY AHMED SALEM</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right pt-4">
                <svg class="decor-wave style-white d-inline-block size-20" version="1.0"
                     xmlns="http://www.w3.org/2000/svg" width="2202.000000pt" height="166.000000pt"
                     viewBox="0 0 2202.000000 166.000000" preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,166.000000) scale(0.100000,-0.100000)"
                       fill="#000000" stroke="none">
                        <path d="M170 1630 c-53 -25 -92 -60 -129 -115 -23 -36 -26 -49 -26 -135 0
    -86 3 -99 26 -135 63 -94 129 -129 263 -139 246 -18 368 -100 648 -439 168
    -205 344 -382 451 -455 104 -71 240 -135 362 -168 94 -26 113 -28 300 -28 185
    0 207 2 298 27 125 33 278 107 389 187 94 67 262 234 368 365 185 230 310 359
    408 422 110 71 265 102 410 83 214 -28 326 -112 617 -465 242 -293 370 -407
    565 -505 189 -94 285 -115 525 -115 166 1 201 4 279 24 304 79 510 233 807
    601 51 63 147 169 213 236 182 183 281 228 491 227 129 -1 214 -22 301 -74 78
    -47 212 -176 329 -316 55 -65 130 -155 168 -201 205 -244 435 -402 687 -470
    87 -24 111 -26 295 -26 185 0 207 2 298 27 117 31 284 109 375 174 108 77 238
    207 407 408 315 374 410 446 627 475 62 8 106 8 166 0 230 -31 328 -108 679
    -536 106 -129 268 -285 366 -352 104 -72 245 -137 364 -169 91 -25 113 -27
    298 -27 187 0 207 2 300 27 55 15 150 52 210 82 198 97 331 216 585 520 168
    202 298 332 385 383 113 66 252 92 394 72 214 -29 327 -114 616 -465 242 -293
    370 -407 565 -505 189 -94 285 -115 525 -115 209 1 288 14 439 76 224 93 376
    221 639 539 231 278 377 408 501 445 96 29 198 38 293 25 213 -28 324 -112
    620 -468 239 -288 369 -404 558 -499 177 -89 272 -113 480 -120 121 -4 182 -1
    250 11 313 54 570 224 835 552 113 140 249 291 319 356 128 117 229 161 405
    174 62 5 107 14 141 30 63 29 73 38 116 99 33 48 34 53 34 145 0 86 -2 99 -27
    137 -38 59 -65 82 -127 111 -51 24 -60 24 -185 19 -179 -8 -285 -36 -451 -120
    -191 -95 -320 -212 -560 -502 -291 -353 -403 -437 -619 -465 -94 -13 -197 -4
    -292 25 -125 37 -258 156 -500 445 -268 322 -416 446 -640 539 -153 62 -230
    75 -444 76 -170 0 -206 -3 -279 -23 -186 -49 -334 -127 -490 -257 -93 -78
    -153 -142 -339 -366 -268 -324 -387 -412 -595 -439 -95 -13 -197 -4 -294 25
    -115 34 -264 163 -457 395 -43 52 -110 132 -148 178 -206 242 -423 389 -673
    458 -94 26 -113 28 -300 28 -185 0 -207 -2 -298 -27 -118 -31 -280 -107 -374
    -173 -106 -75 -252 -223 -411 -414 -298 -359 -408 -441 -626 -470 -94 -13
    -210 -1 -300 30 -127 43 -249 152 -466 415 -312 378 -519 535 -807 612 -91 25
    -113 27 -298 27 -187 0 -206 -2 -300 -28 -122 -33 -258 -97 -362 -168 -107
    -73 -283 -250 -451 -455 -159 -192 -276 -307 -372 -363 -143 -85 -342 -100
    -521 -40 -132 45 -239 142 -486 439 -177 212 -270 307 -383 391 -108 80 -276
    162 -405 197 -93 26 -113 28 -295 28 -214 -1 -292 -14 -442 -76 -224 -92 -374
    -217 -638 -534 -336 -403 -451 -479 -715 -478 -264 2 -395 95 -745 528 -103
    127 -237 261 -329 331 -111 83 -280 166 -406 201 -93 25 -114 27 -300 27 -185
    0 -207 -2 -298 -27 -119 -32 -260 -97 -364 -169 -115 -79 -255 -219 -444 -444
    -287 -343 -383 -414 -601 -444 -94 -13 -211 -1 -302 30 -124 42 -250 154 -466
    415 -253 306 -401 438 -596 532 -152 73 -274 103 -439 109 -117 5 -134 3 -175
    -16z"/>
                    </g>
                </svg>
            </div>
        </div>
    </div>
</section>

@include('modules.presentation.join_the_cause_subscribe2')


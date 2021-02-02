@php

    $relatedPages = [];
    $hdrTypeActive = [];
    $hdrColorType = [];
    $hdrLinkText = [];
    $hdrLearnMoreLink = [];
    $hdrTitle = [];
    $hdrText = [];
    $hdrBgImage = [];

    for ($i=1; $i<=4; $i++) {
        $hdrColorType[$i] = "";
        $hdrTypeActive[$i] = "";
        $hdrLinkText[$i] = "";
        $hdrLearnMoreLink[$i] = "";
        $hdrTitle[$i] = "";
        $hdrText[$i] = "";
        $hdrBgImage[$i] = "";
        $donateLink[$i] = "";
    }

    for ($i = 1; $i <= 4; $i++) {
        if (isset($parameters['hdr_color_type_' . $i])) {
            $hdrColorType[$i] = $parameters['hdr_color_type_' . $i];
        }
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
        if (isset($parameters['hdr_donate_link_' .$i])) {
            $donateLink[$i] = $parameters['hdr_donate_link_' . $i];
        }
    }

    $blogs = \App\Models\Page::lastBlogs(3);

    $style = 'style-1';

    if ((isset($hdrColorType[0])) && ($hdrColorType[0] === 'red')) {
        $style = 'style-2';
    }

@endphp

@empty(!$hdrTypeActive)

    <section class="main-page-header {{ $style }}" swiper-wrapper="header2">
        <div class="wrap">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @for ($i = 1; $i <= 4; $i++)
                        @if(in_array($i, $hdrTypeActive ))
                            @php
                                if ($hdrColorType[$i] === 'blue')  {
                                    $style = 'style-1';
                                }  else {
                                    $style = 'style-2';
                                }
                            @endphp
                            <div class="swiper-slide" data-style="{{ $style }}" header-slider-slide>
                                <div class="body">
                                    <div class="left">
                                        <div class="mb-4">
                                            <a href="{{ $hdrLearnMoreLink[$i] }}"
                                               class="learn-more text-underline text-dark"><b>{{ $hdrLinkText[$i] }}</b></a>
                                        </div>
                                        <div class="title mb-3">
                                            @if($hdrColorType[$i] === 'blue')
                                                {!! \App\Helpers\StrHelper::addSpanWithClass($hdrTitle[$i], 'text-info') !!}
                                            @else
                                                {!! \App\Helpers\StrHelper::addSpanWithClass($hdrTitle[$i], 'text-danger') !!}
                                            @endif
                                        </div>
                                        <p class="mb-5">{!! $hdrText[$i] !!}</p>
                                        <a href="{{ $donateLink[$i] }}"
                                           class="btn @if($hdrColorType[$i] === 'blue') btn-info @else btn-danger @endif">Donate
                                            now</a>
                                    </div>
                                    <a href="{{ $hdrLearnMoreLink[$i] }}" class="right"
                                       style="background-image: url('{{ $hdrBgImage[$i] }}')"></a>
                                    <a href="#" header-slider-next class="view-more swiper-button-next"><i
                                            class="moon-icons-arrow-right"></i></a>
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

@include('modules.presentation.who_we_are')

@include('modules.presentation.our_work')

@include('modules.presentation.current_projects')

@include('modules.presentation.latest_projects')

@include('modules.presentation.lets_join')

@include('modules.presentation.view_all_projects')

@if(count($blogs) >= 3)
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
                <b>WHAT'S NEW <i class="moon-icons-arrow-right"></i></b>
                <a href="{{ \App\Models\Page::getNewsroomPage() ? \App\Models\Page::getNewsroomPage()->slug : '#' }}" class="text-underline text-uppercase letter-spacing-1">
                    <b>visit newsroom</b></a>
            </div>
            <div>
                <div class="row gutter-5">
                    <div class="col-12 col-lg-6 col-xl-6">
                        <div class="item vertical">
                            <a class="img" href="{{ $blogs[0]->getActualPageInstanceAttribute()->slug }}">
                                <span
                                    style="background-image: url({{ $blogs[0]->getActualPageInstanceAttribute()->preview_img }})"></span>
                                <span class="plus bg-info"><i class="moon-icons-plus"></i></span>
                            </a>
                            <div class="descr">
                                <a class="font-size-18 letter-spacing-1 mb-0 text-dark d-block" href="{{ $blogs[0]->getActualPageInstanceAttribute()->slug }}">
                                    <b>
                                        {{ \App\Helpers\StrHelper::lengthLimit($blogs[0]->getActualPageInstanceAttribute()->name, 30) }}
                                    </b>
                                </a>
                                <a class="font-size-16 mb-4 letter-spacing-0 text-dark text-decoration-none" href="{{ $blogs[0]->getActualPageInstanceAttribute()->slug }}">
                                    {!! \App\Helpers\StrHelper::lengthLimit($blogs[0]->getActualPageInstanceAttribute()->parameters['hdr_text'], 40) !!}
                                </a>
                                <div class="date mt-4 pb-2">
                                    {{ $blogs[0]->created_at->format('F d, Y') }}
                                    BY {{ $blogs[0]->getActualPageInstanceAttribute()->parameters['written_by'] ?? '' }}</div>
                                <div class="stat" data-token="{{ env('FACEBOOK_KEY') }}|{{ env('FACEBOOK_SECRET')}}"
                                   data-url="{{ request()->getSchemeAndHttpHost() . '/' .  $blogs[0]->getActualPageInstanceAttribute()->slug }}">
                                   <span>0</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-xl-6">
                        <div class="pt-5 pb-5 pt-lg-0 pb-lg-0"></div>
                        <div class="item">
                            <a class="img" href="{{ $blogs[1]->getActualPageInstanceAttribute()->slug }}">
                                <span
                                    style="background-image: url({{ $blogs[1]->getActualPageInstanceAttribute()->preview_img }})"></span>
                                <span class="plus bg-danger"><i class="moon-icons-plus"></i></span>
                            </a>
                            <div class="descr">
                                <a class="font-size-18 letter-spacing-1 mb-0 text-dark d-block" href="{{ $blogs[1]->getActualPageInstanceAttribute()->slug }}">
                                    <b>
                                        {{ \App\Helpers\StrHelper::lengthLimit($blogs[1]->getActualPageInstanceAttribute()->name, 30) }}
                                    </b>
                                </a>
                                <a class="font-size-16 mb-4 letter-spacing-0 text-dark text-decoration-none" href="{{ $blogs[1]->getActualPageInstanceAttribute()->slug }}">
                                    {!! \App\Helpers\StrHelper::lengthLimit($blogs[1]->getActualPageInstanceAttribute()->parameters['hdr_text'], 40) !!}
                                </a>
                                <div class="date mt-4 pb-2">
                                    {{ $blogs[1]->created_at->format('F d, Y') }}
                                    BY {{ $blogs[1]->getActualPageInstanceAttribute()->parameters['written_by'] ?? '' }}</div>

                            </div>
                        </div>
                        <div class="item">
                            <a class="img" href="{{ $blogs[2]->getActualPageInstanceAttribute()->slug }}">
                                <span
                                    style="background-image: url({{ $blogs[2]->getActualPageInstanceAttribute()->preview_img }})"></span>
                                <span class="plus bg-warning"><i class="moon-icons-plus"></i></span>
                            </a>
                            <div class="descr">
                                <a class="font-size-18 letter-spacing-1 mb-0 text-dark d-block" href="{{ $blogs[2]->getActualPageInstanceAttribute()->slug }}">
                                    <b>
                                        {{ \App\Helpers\StrHelper::lengthLimit($blogs[2]->getActualPageInstanceAttribute()->name, 30) }}
                                    </b>
                                </a>
                                <a class="font-size-16 mb-4 letter-spacing-0 text-dark text-decoration-none" href="{{ $blogs[2]->getActualPageInstanceAttribute()->slug }}">
                                    {!! \App\Helpers\StrHelper::lengthLimit($blogs[2]->getActualPageInstanceAttribute()->parameters['hdr_text'], 40) !!}
                                </a>
                                <div class="date mt-4 pb-2">
                                    {{ $blogs[2]->created_at->format('F d, Y') }}
                                    BY {{ $blogs[2]->getActualPageInstanceAttribute()->parameters['written_by'] ?? '' }}</div>
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
@endif

@include('modules.presentation.join_the_cause_subscribe2')


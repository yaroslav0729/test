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
$tagText = '';
$tagClass = '';

 $featuredCompaignLink = "";

for ($i=1; $i<=4; $i++) {
    $hdrTypeActive[$i] = "";
    $hdrLinkText[$i] = "";
    $hdrLearnMoreLink[$i] = "";
    $hdrTitle[$i] = "";
    $hdrText[$i] = "";
    $hdrBgImage[$i] = "";
    $donateLink[$i] = "";
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
    if (isset($parameters['hdr_donate_link_' .$i])) {
        $donateLink[$i] = $parameters['hdr_donate_link_' . $i];
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

    if (isset($parameters['feat_camp_link'])) {
        $featuredCompaignLink = $parameters['feat_camp_link'];
    }

    if (isset($parameters['tag_text'])) {
        $tagText = $parameters['tag_text'];
    }

    if (isset($parameters['tag_class'])) {
        $tagClass= $parameters['tag_class'];
    }

    $blogs = \App\Models\Page::lastBlogs(4);

@endphp

@empty(!$hdrTypeActive)
<section class="main-page-header style-1" style="display: none1" swiper-wrapper="header-mabile-2">
    <div class="wrap">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @for ($i = 1; $i <= 4; $i++)
                    @if(in_array($i, $hdrTypeActive ))
                        <div class="swiper-slide">
                             <div class="body">
                                <div class="left">

                                    @empty($tagText)
                                        <div class="tag bg-info-light text-info">Ramathan</div>
                                    @else
                                        <div class="tag {{ $tagClass }}">{{ $tagText }}</div>
                                    @endempty

                                    <div class="mb-4">
                                        <a href="{{ $hdrLearnMoreLink[$i] }}" class="text-underline text-dark"><b>{{ $hdrLinkText[$i] }}</b></a>
                                    </div>
                                    <div class="title mb-3">
                                        @if($hdrColorType === 'blue')
                                            {!! \App\Helpers\StrHelper::addSpanWithClass($hdrTitle[$i], 'text-info') !!}
                                        @else
                                            {!! \App\Helpers\StrHelper::addSpanWithClass($hdrTitle[$i], 'text-danger') !!}
                                        @endif
                                    </div>
                                    <p class="mb-3">{!! $hdrText[$i] !!}</p>
                                    <a href="{{ $donateLink[$i] }}" style="position: relative; z-index: 2" class="btn @if($hdrColorType === 'blue') btn-info @else btn-danger @endif">Donate now</a>
                                    <div class="text-right mt-n4 d-block">
                                        <a href="#" class="view-more swiper-button-next"><i class="moon-icons-arrow-right"></i></a>
                                        <div class="black-line"></div>
                                    </div>
                                </div>
                                <a href="{{ $hdrLearnMoreLink[$i] }}" class="right" style="background-image: url('{{ $hdrBgImage[$i] }}')"></a>
                            </div>
                        </div>
                    @endif
                @endfor
            </div>
        </div>
    </div>
</section>
@endempty

<section class="who-we-are">
    <svg class="decor-wave size-15 style-danger mb-4 mt-4" version="1.0" xmlns="http://www.w3.org/2000/svg" width="2202.000000pt" height="166.000000pt" viewBox="0 0 2202.000000 166.000000" preserveAspectRatio="xMidYMid meet">
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
    <p class="font-size-25 mb-4">{!! $whoTitle !!}</p>
    <div class="img-video play-tr videoWrapper" style="">
        <iframe width="1280" height="720" src="https://www.youtube.com/embed/{{ $whoVideo }}"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>

    </div>
   {{-- <div class="img-video" style="background-image: url(img/content/Video-placement-1.jpg)"><i class="fas fa-play-circle"></i></div>--}}
    <div class="pt-4">
        <div class="mb-4">
            <a href="{{ $whoLink }}" class="text-underline text-dark"><b>{{ $whoLinkText }}</b></a>
        </div>
        <p class="font-size-16">{!! $whoText !!}</p>
    </div>
</section>

<div class="help-info-swiper" swiper-wrapper="help_info">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <span>8k</span>
                <span>People helped</span>
            </div>
            <div class="swiper-slide">
                <span>36</span>
                <span>Countries</span>
            </div>
            <div class="swiper-slide">
                <span>1'407</span>
                <span>Volunteers this year</span>
            </div>
        </div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"><i class="moon-icons-arrow-right"></i></div>
    </div>
</div>

@include('modules.presentation.current_projects')

@include('modules.presentation.lets_join')

<section class="widget-about-project">
    <div class="row gutter-0">
        <div class="col-12 descr">
            <div class="text-right mb-4">
                <a href="#"><i class="moon-icons-plus"></i></a>
            </div>
            <div>
                <p class="font-size-25 text-uppercase" style="font-weight: 100"><b>help orphans</b> & the environment</p>
                <p class="font-size-16" style="font-weight: 700">Critical campaign info, 60 ch. lorem ipsum dolor sit ametas.</p>
                <a href="#" class="text-underline ">LEARN MORE</a>
            </div>
        </div>
        <div class="col-12 img" style="background-image: url(img/content/widget-about-project-1.jpg)"></div>

    </div>
</section>

@if(count($blogs) >= 4)
    <section class="whats-new">
    <div class="wrap">
        <div class="title">
            <div>
                <svg class="decor-wave d-inline-block" version="1.0" xmlns="http://www.w3.org/2000/svg" width="2202.000000pt" height="166.000000pt" viewBox="0 0 2202.000000 166.000000" preserveAspectRatio="xMidYMid meet">
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
            <b>WHAT'S NEW</b>
        </div>
        <div>
            <div swiper-wrapper="whats-new">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="item vertical">
                                <a class="img" href="{{ $blogs[0]->getActualPageInstanceAttribute()->slug }}">
                                    <span style="background-image: url({{ $blogs[0]->getActualPageInstanceAttribute()->preview_img }})"></span>
                                    <span class="plus bg-info"><i class="moon-icons-plus"></i></span>
                                </a>
                                <div class="descr">
                                    <a class="font-size-16 mb-0 text-ellipsis text-dark text-decoration-none" href="{{ $blogs[0]->getActualPageInstanceAttribute()->slug }}">
                                        <b>
                                            {{ \App\Helpers\StrHelper::lengthLimit($blogs[0]->getActualPageInstanceAttribute()->name, 30) }}
                                        </b>
                                    </a>
                                    <a class="font-size-16 mb-0 text-dark text-decoration-none" href="{{ $blogs[0]->getActualPageInstanceAttribute()->slug }}">
                                        {!! \App\Helpers\StrHelper::lengthLimit($blogs[0]->getActualPageInstanceAttribute()->parameters['hdr_text'], 40) !!}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="item">
                                <a class="img" href="{{ $blogs[1]->getActualPageInstanceAttribute()->slug }}">
                            <span style="background-image: url({{ $blogs[1]->getActualPageInstanceAttribute()->preview_img }})">
                                <i class="fas fa-play-circle"></i>
                            </span>
                                    <span class="plus bg-danger"><i class="moon-icons-plus"></i></span>
                                </a>
                                <div class="descr">
                                    <a class="font-size-16 mb-0 text-ellipsis text-dark text-decoration-none" href="{{ $blogs[1]->getActualPageInstanceAttribute()->slug }}">
                                        <b>
                                            {{ \App\Helpers\StrHelper::lengthLimit($blogs[1]->getActualPageInstanceAttribute()->name, 30) }}
                                        </b>
                                    </a>
                                    <a class="font-size-16 mb-0 text-dark text-decoration-none" href="{{ $blogs[1]->getActualPageInstanceAttribute()->slug }}">
                                        {!! \App\Helpers\StrHelper::lengthLimit($blogs[1]->getActualPageInstanceAttribute()->parameters['hdr_text'], 40) !!}
                                    </a>
                                </div>
                            </div>
                            <div class="item">
                                <a class="img" href="{{ $blogs[2]->getActualPageInstanceAttribute()->slug }}">
                                    <span style="background-image: url({{ $blogs[2]->getActualPageInstanceAttribute()->preview_img }})"></span>
                                    <span class="plus bg-warning"><i class="moon-icons-plus"></i></span>
                                </a>
                                <div class="descr">
                                    <a class="font-size-16 mb-0 text-ellipsis text-dark text-decoration-none" href="{{ $blogs[2]->getActualPageInstanceAttribute()->slug }}">
                                        <b>
                                            {{ \App\Helpers\StrHelper::lengthLimit($blogs[2]->getActualPageInstanceAttribute()->name, 30) }}
                                        </b>
                                    </a>
                                    <a class="font-size-16 mb-0 text-dark text-decoration-none" href="{{ $blogs[2]->getActualPageInstanceAttribute()->slug }}">
                                        {!! \App\Helpers\StrHelper::lengthLimit($blogs[2]->getActualPageInstanceAttribute()->parameters['hdr_text'], 40) !!}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="item vertical">
                                <a class="img" href="{{$blogs[3]->getActualPageInstanceAttribute()->slug }}">
                                    <span style="background-image: url({{ $blogs[3]->getActualPageInstanceAttribute()->preview_img }})"></span>
                                    <span class="plus bg-info"><i class="moon-icons-plus"></i></span>
                                </a>
                                <div class="descr">
                                    <p class="font-size-16 mb-0 text-ellipsis">
                                        <b>{{ \App\Helpers\StrHelper::lengthLimit($blogs[3]->getActualPageInstanceAttribute()->name, 30) }}</b>
                                    </p>
                                    <p class="font-size-16 mb-0">
                                        {!! \App\Helpers\StrHelper::lengthLimit($blogs[3]->getActualPageInstanceAttribute()->parameters['hdr_text'], 40) !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="down-link">
                    <a href="{{ \App\Models\Page::getNewsroomPage() ? \App\Models\Page::getNewsroomPage()->slug : '#' }}">visit newsroom</a>
                    <a href="#" class="view-more swiper-button-next"><i class="moon-icons-arrow-right"></i></a>
                    <div class="black-line"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@include('modules.presentation.join_the_cause_subscribe2')


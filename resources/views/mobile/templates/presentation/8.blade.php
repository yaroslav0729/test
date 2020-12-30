@php

    $bgImage = "";
    $ourMissionTitle = "";
    $ourValuesDescription = "";
    $ourValuesVideo = "";
    $mapImage = "";
    $mapAlternativeImage = "";

    for ($i=1; $i<=4; $i++) {
        $actionName[$i] = "";
        $actionPhoto[$i] = "";
        $actionSlogan[$i] = "";
        $actionTitle[$i] = "";
        $actionDescription[$i] = "";
        $actionLearnMoreLink[$i] = "";
    }

    for ($i=1; $i<=3; $i++){
        ${'storyPhoto' . $i} = "";
        ${'storyYear' . $i} = "";
        ${'storyText' . $i} = "";
    }

    for ($i=1; $i<=2; $i++){
        ${'lifeChangingPhoto' . $i} = "";
        ${'lifeChangingPhrase' . $i} = "";
    }

    $lifeChangingBlockTitle = "";
    $lifeChangingBlockText = "";

    if (isset($parameters['background_image'])) {
        $bgImage = $parameters['background_image'];
    }

    if (isset($parameters['our_mission_title'])) {
        $ourMissionTitle = $parameters['our_mission_title'];
    }

    if (isset($parameters['our_values_description'])) {
        $ourValuesDescription = $parameters['our_values_description'];
    }

    if (isset($parameters['our_values_video'])) {
        $ourValuesVideo = $parameters['our_values_video'];
    }

    if (isset($parameters['map_image'])) {
        $mapImage = $parameters['map_image'];
    }

    if (isset($parameters['map_alt_image'])) {
        $mapAlternativeImage = $parameters['map_alt_image'];
    }

    $colorNameClass = [
        1 => 'bg-primary-light',
        2 => 'bg-warning',
        3 => 'bg-danger',
        4 => 'bg-info' ];

    $actionActive = $parameters['action_active'] ?? [];

    for ($i=1; $i<=4; $i++){
        if (isset($parameters['action_active_' . $i])) {
            $actionActive[$i] = $parameters['action_active_' . $i];
        }
        if (isset($parameters['action_name_' . $i])) {
            $actionName[$i] = $parameters['action_name_' . $i];
        }
        if (isset($parameters['action_photo_' .$i])) {
            $actionPhoto[$i] = $parameters['action_photo_' . $i];
        }
        if (isset($parameters['action_slogan_' .$i])) {
            $actionSlogan[$i] = $parameters['action_slogan_' . $i];
        }
        if (isset($parameters['action_title_' .$i])) {
            $actionTitle[$i] = $parameters['action_title_' . $i];
        }
        if (isset($parameters['action_description_' .$i])) {
            $actionDescription[$i] = $parameters['action_description_' . $i];
        }
        if (isset($parameters['action_learn_more_link_' .$i])) {
            $actionLearnMoreLink[$i] = $parameters['action_learn_more_link_' . $i];
        }
    }

    $storyActive = $parameters['story_active'] ?? [];

    for ($i=1; $i<=3; $i++){
        if (isset($parameters["story_year_{$i}"])) {
            ${'storyYear' . $i} = $parameters["story_year_{$i}"];
        }
        if (isset($parameters["story_photo_{$i}"])) {
            ${'storyPhoto' . $i} = $parameters["story_photo_{$i}"];
        }
        if (isset($parameters["story_text_{$i}"])) {
            ${'storyText' . $i} = $parameters["story_text_{$i}"];
        }
    }

    for ($i=1; $i<=2; $i++){
        if (isset($parameters["changing_block_photo_{$i}"])) {
            ${'lifeChangingPhoto' . $i} = $parameters["changing_block_photo_{$i}"];
        }
        if (isset($parameters["changing_block_phrase_{$i}"])) {
            ${'lifeChangingPhrase' . $i} = $parameters["changing_block_phrase_{$i}"];
        }
    }

    $changingActive = $parameters['changing_active'] ?? [];

    if (isset($parameters['changing_block_title'])) {
        $lifeChangingBlockTitle = $parameters['changing_block_title'];
    }
    if (isset($parameters['changing_block_text'])) {
        $lifeChangingBlockText = $parameters['changing_block_text'];
    }

@endphp

<section class="who-we-are-head" style="background-image: url({{ $bgImage }});">
    <div>OUR MISSION</div>
    <h1>{!! $ourMissionTitle !!}</h1>
</section>

<section class="our-values">
    <div class="title">OUR VALUES</div>
    <p class="pr-5">{!! $ourValuesDescription !!}</p>
    <div class="img-video play-tr videoWrapper" style="">
        <iframe width="1280" height="720" src="https://www.youtube.com/embed/{{ $ourValuesVideo }}"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
    </div>
</section>
<section class="gw-map-btn">
    <div style="background-image: url({{ $mapImage }})" alt-src="{{ $mapAlternativeImage }}">
        <a href="#" id="btn-view-global-work" class="btn btn-info">View Global Work</a>
    </div>
</section>

@empty(!$actionActive)
<section class="mb-5">
    <p class="font-size-20 text-uppercase"><b>Our values in action</b></p>
    <div class="black-line"></div>
</section>
<section class="values-action" swiper-wrapper="our-values">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @for ($i = 1; $i <= 4; $i++)
                @if(in_array($i, $actionActive ))
                <div class="swiper-slide {{ $colorNameClass[$i] }}">
                    <i class="moon-icons-arrow-right swiper-button-next"></i>
                    <div class="text">
                        <p class="text-1">{!! $actionSlogan[$i] !!}</p>
                        <p class="text-2">{!! $actionTitle[$i] !!}</p>
                        <p class="text-3">{!! $actionDescription[$i] !!}</p>
                    </div>
                    <div><a href="{{ $actionLearnMoreLink[$i] }}" class="btn btn-dark br-0"><b>LEARN MORE</b></a></div>
                    <div class="img" style="background-image: url({{ $actionPhoto[$i] }})">&nbsp;
                        <span class="place"><i class="fal fa-map-marker-alt"></i> ROHINGYA</span>
                    </div>
                </div>
                @endif
            @endfor
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>
@endempty

@empty(!$storyActive)
<section class="our-story-swiper" swiper-wrapper="our-story">
    <div class="wrap">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @for ($i = 1; $i <= 2; $i++)
                <div class="swiper-slide">
                    <div class="box">
                        <div class="row title">
                            <div class="col-9"><span class="d-block">OUR STORY | {{ ${'storyYear' . $i} }}</span></div>
                        </div>
                        <div class="black-line"></div>
                        <p class="">{!! ${'storyText' . $i} !!}</p>
                    </div>
                    <div class="img-box">
                        <div class="bg-warning">
                            <div class="img" style="background-image: url({{ ${'storyPhoto' . $i} }})"></div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
        <div class="swiper-button-next"><i class="moon-icons-arrow-right"></i></div>
        <div class="swiper-button-prev"><i class="moon-icons-arrow-left"></i></div>
        <div class="swiper-pagination"></div>
    </div>
</section>
@endempty

<section class="mb-5">
    <p class="font-size-25"><b>Life changing support.</b></p>
</section>

@empty(!$changingActive)
<section class="promo-project-swiper" swiper-wrapper="our-support">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @for ($i = 1; $i <= 2; $i++)
                <div class="swiper-slide">
                    <div class="img" style="background-image: url({{ ${'lifeChangingPhoto' . $i} }})">
                        <a href="#" class="prev swiper-button-prev"><i class="moon-icons-arrow-left"></i></a>
                        <a href="#" class="next swiper-button-next"><i class="moon-icons-arrow-right"></i></a>
                    </div>
                    <div class="black-line"></div>
                    <div class="text bg-danger-light">
                        {{ ${'lifeChangingPhrase' . $i} }}
                        <a href="#" class="btn btn-info">Donate to this project &nbsp;&nbsp;<i class="moon-icons-plus"></i></a>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>
@endempty

<section class="blog-article-body">
    <div class="body">
        <h2>{{ $lifeChangingBlockTitle }}</h2>
        {!! $lifeChangingBlockText !!}
    </div>
</section>

<div class="pt-5 pb-5"></div>

<section class="discover-more bg-light">
    <div class="wrap">
        <div class="title text-center">
            <b class="font-size-25 text-uppercase d-inline-block mb-3">MAKE A DIFFERENCE</b>
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
        @include('modules.presentation.related_pages', [
            'parameters' => $parameters
        ])
        <div class="text-center mt-5 mb-4">
            <a href="#" class="text-uppercase text-underline text-danger font-size-16"><b>visit newsroom</b> <i class="moon-icons-arrow-right font-size-20"></i></a>
        </div>
    </div>
</section>

<section class="join-cause pb-0 with-glyph">
    <div class="wrap">
        <div class="title text-center">
            <p class="font-size-25"><b>Join the cause!</b></p>
        </div>
        <p class="font-size-20 mb-4  text-center">
            There are so many ways to help, stay in the loop with our Newsletter.
        </p>
        <form action="/" class="d-flex mb-4">
            <input type="text" placeholder="Your email address" class="flex-grow-1">
            <button type="submit"><i class="far fa-chevron-right"></i></button>
        </form>
        <div class="img" style="background-image: url(img/content/join-cause-2.jpg)"></div>
    </div>
</section>

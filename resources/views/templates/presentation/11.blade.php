@php

    $mainTitle = "";
    $mainImage = "";
    $colTitle1 = "";
    $colText1 = "";
    $colTitle2 = "";
    $colText2 = "";
    $colTitle3 = "";
    $colText3 = "";
    $exploreTitle = "";
    $exploreText = "";
    $interestedTitle = "";
    $interestedText = "";
    $volonteerNowLink = "";
    $projImg1 = "";
    $projText1 = "";
    $projImg2 = "";
    $projText2 = "";

    if (isset($parameters['main_title'])) {
        $mainTitle = $parameters['main_title'];    
    }

    if (isset($parameters['main_image'])) {
        $mainImage = $parameters['main_image'];    
    }

    if (isset($parameters['column1_title'])) {
        $colTitle1 = $parameters['column1_title'];    
    }

    if (isset($parameters['column1_text'])) {
        $colText1 = $parameters['column1_text'];    
    }

    if (isset($parameters['column2_title'])) {
        $colTitle2 = $parameters['column2_title'];    
    }

    if (isset($parameters['column2_text'])) {
        $colText2 = $parameters['column2_text'];    
    }

    if (isset($parameters['column2_title'])) {
        $colTitle3 = $parameters['column2_title'];    
    }

    if (isset($parameters['column3_text'])) {
        $colText3 = $parameters['column3_text'];    
    }

    if (isset($parameters['explore_proj_title'])) {
        $exploreTitle = $parameters['explore_proj_title'];    
    }

    if (isset($parameters['explore_proj_text'])) {
        $exploreText = $parameters['explore_proj_text'];    
    }

    if (isset($parameters['interested_title'])) {
        $interestedTitle = $parameters['interested_title'];    
    }

    if (isset($parameters['interested_text'])) {
        $interestedText = $parameters['interested_text'];    
    }

    if (isset($parameters['volonteer_link'])) {
        $volonteerNowLink = $parameters['volonteer_link'];    
    }

    if (isset($parameters['proj_img1'])) {
        $projImg1 = $parameters['proj_img1'];    
    }

    if (isset($parameters['proj_text1'])) {
        $projText1 = $parameters['proj_text1'];    
    }

    if (isset($parameters['proj_img2'])) {
        $projImg2 = $parameters['proj_img2'];    
    }

    if (isset($parameters['proj_text2'])) {
        $projText2 = $parameters['proj_text2'];    
    }
  
@endphp

<section class="head-Volunteer">
    <div class="row">
        <div class="col-6">
            @empty($mainTitle)
            <h1>Volunteer<br>& help empower communities.</h1>
            @else
            <h1>{{ $mainTitle }}</h1>
            @endempty

        </div>
        <div class="col-6">
            @empty($mainImage)
            <img src="img/content/Volunteer1.jpg" alt="" class="w-100">
            @else
            <img src="{{ $mainImage }}" alt="" class="w-100">
            @endempty
        </div>
    </div>
    <div class="box">
        <div class="row align-items-center">
            <div class="col-8">
                <p>Latest mission | Tanzania 2oth August 2020</p>
            </div>
            <div class="col-4 text-right">
                <a href="#" class="btn btn-primary">Apply now</a>
            </div>
        </div>
    </div>
</section>


<section class="how-does-work with-lines">
    <div class="title">
        <p>Why should I volunteer?</p>
        <span>Find the mission you love</span>
    </div>
    <div class="row">
        <div class="col pr-0 pr-md-5">
            <div class="item">
                <div class="num">01</div>
                <div>{{ $colTitle1 }}</div>
                <p>{{ $colText1 }}</p>
            </div>
        </div>
        <div class="col pl-0 pr-0 pl-md-5  pr-0 pr-md-5">
            <div class="item">
                <div class="num">02</div>
                <div>{{ $colTitle2 }}</div>
                <p>{{ $colText2 }}</p>
            </div>
        </div>
        <div class="col">
            <div class="item pl-0 pl-md-5">
                <div class="num">03</div>
                <div>{{ $colTitle2 }}</div>
                <p>{{ $colText3 }}</p>
            </div>
        </div>
    </div>
</section>


<section class="explore-past-missions bg-danger-light">
    <div class="row">
        <div class="col-12 col-md-4 pr-5">
            @empty($exploreTitle)
            <p class="font-size-40 mb-3"><b>Explore past projects</b></p>
            @else
            <p class="font-size-40 mb-3"><b>{{ $exploreTitle }}</b></p>
            @endempty

            @empty($exploreTitle)
            <p class="font-size-16 mb-5">210 Characters undos omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicab. </p>
            @else
            <p class="font-size-16 mb-5">{{ $exploreText }}</p>
            @endempty

            <svg class="decor-wave size-70 style-danger" style="position: relative; top: 50px; left: -200%" version="1.0" xmlns="http://www.w3.org/2000/svg" width="2202.000000pt" height="166.000000pt" viewBox="0 0 2202.000000 166.000000" preserveAspectRatio="xMidYMid meet">
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
        <div class="col-12 col-md-8">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="item mt-n4">
                        @empty($projImg1)
                        <img src="img/content/explore-past-missions3.jpg" alt="">
                        @else 
                        <img src="{{ $projImg1 }}" alt="">
                        @endempty

                        @empty($projText1)
                        <span class="place"><span class="text-dark"><i class="fal fa-map-marker-alt"></i> Tanzania, africa</span></span>
                        @else 
                        <span class="place"><span class="text-dark"><i class="fal fa-map-marker-alt"></i> {{ $projText1 }}</span></span>
                        @endempty
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="item mt-5">
                        @empty($projImg2)
                        <img src="img/content/explore-past-missions4.jpg" alt="">
                        @else 
                        <img src="{{ $projImg2 }}" alt="">
                        @endempty

                        @empty($projText2)
                        <span class="place"><span class="text-dark"><i class="fal fa-map-marker-alt"></i> LONDON, UK</span></span>
                        @else
                        <span class="place"><span class="text-dark"><i class="fal fa-map-marker-alt"></i> {{ $projText2 }}</span></span>
                        @endempty
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="be-part-possible bg-danger-light">
    <div class="row align-items-center">
        <div class="col-12 col-md-6">
            <div class="help-info-grid">
                <div class="margin-top">
                    <span>8.2k</span>
                    <span>Meals provided</span>
                </div>
                <div>
                    <span>10.1k</span>
                    <span>Children educated</span>
                </div>
                <div>
                    <span>6.6k</span>
                    <span>People empowered</span>
                </div>
                <div>
                    <span>8k</span>
                    <span>Wells built</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 pl-5">
            @empty($interestedTitle)
            <p class="font-size-40 mb-3"><b>Interested? Volunteer today</b></p>
            @else 
            <p class="font-size-40 mb-3"><b>{{ $interestedTitle }}</b></p>
            @endempty

            @empty($interestedText)
            <p class="font-size-16  mb-5">210 Characters undos omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicab. </p>
            @else 
            <p class="font-size-16  mb-5">{{ $interestedText }}</p>
            @endempty
            <div class="pt-0">
                <a href="{{ $volonteerNowLink }}" class="btn btn-red">Volunteer now!</a>
            </div>
        </div>
    </div>
</section>

<div class="pt-5 pb-5"></div>

@include('modules.presentation.mission_possible')

<div class="pt-5 pb-5"></div>

@include('modules.presentation.related_pages')

@include('modules.presentation.join_the_cause_subscribe')

@php

    if (isset($parameters['per_page'])) {
        $perPage = (int)$parameters['per_page'] > 0 ? (int)$parameters['per_page'] : 6;
    }

    $keywordType = Request::get('type');
    $keywordTypeParticipate = Request::get('participate');

    $query = \App\Models\Event::whereDate('start_date', '>=', now());

    if (!empty($keywordType)) {
        $query->where('entry_type', $keywordType);
    }

    if (!empty($keywordTypeParticipate)) {
        $query->where('event_type', $keywordTypeParticipate);
    }

    $events = $query->orderBy('start_date')->paginate($perPage);
    $eventsForSlide = $events->count() < 3 ? \App\Models\Event::whereDate('start_date', '>=', now())->orderBy('start_date')->take(3)->get() : $events->take(3);

@endphp

<section class="pt-5">
    <p class="mb-3"><b>FEATURED EVENT</b></p>
    <div class="black-line"></div>
</section>

<section class="events-home-swiper" swiper-wrapper="events-slider-mobile">
    <div class="wrap">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach($eventsForSlide as $event)
                    <div class="swiper-slide">
                        <div class="img"
                             style="background-image: url({{ $event->page->getActualPageInstanceAttribute()->preview_img }})"></div>
                        <div class="text">
                            <div>
                                <div class="date">{{ $event->start_date->format('M') }}
                                    <span>{{ $event->start_date->format('d') }}</span></div>
                                <div class="place"><i class="fal fa-map-marker-alt"></i> {{ $event->location }}</div>
                                <div class="tl">{{ $event->name }}</div>
                                <svg class="decor-wave style-white mb-2" version="1.0"
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
                                <div class="pt-3"></div>
                                <p>{{ $event->page->getActualPageInstanceAttribute()->preview_text }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="swiper">
            <div class="swiper-button-next"><i class="moon-icons-arrow-right"></i></div>
        </div>
    </div>
</section>

<section class="upcoming-events">
    <div class="title">
        <p class="font-size-30"><b>Upcoming Events</b></p>
        <br>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <input type="hidden" id="per-page" value="{{ $perPage }}">
                    <div class="form-group">
                        <select name="type" class="form-control filter" id="filter-type">
                            <option value="">EVENT TYPE</option>
                            @foreach (\App\Models\Event::ALL_TYPES_ENTRY as $typeId => $typeLabel)
                                <option class="events-filter" value="{{ $typeId }}"
                                    @if($typeId === intval($keywordType)) selected @endif
                                >{{ $typeLabel }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <div class="form-group">
                        <select name="type" class="form-control filter" id="filter-participate">
                            <option value="">LIVE EVENTS</option>
                            @foreach (\App\Models\Event::ALL_TYPE_EVENT as $typeId => $typeEvent)
                                <option class="events-filter" value="{{ $typeId }}"
                                        @if($typeId === intval($keywordTypeParticipate)) selected @endif
                                >{{ $typeEvent }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="events-content">
        <div class="list">
            @foreach($events as $event)
                <div class="item">
                    <a href="{{ url($event->page->getActualPageInstanceAttribute()->slug) }}" class="img d-block"
                       style="background-image: url({{ $event->page->getActualPageInstanceAttribute()->preview_img }})">
                        <span class="price text-uppercase">
                         @if($event->entry_type === \App\Models\Event::ENTRY_PAID)
                                £{{ $event->page->getActualPageInstanceAttribute()->parameters['event_entry_price'] }}
                            @else
                                {{ \App\Models\Event::ALL_TYPES_ENTRY[$event->entry_type] }}
                            @endif
                        </span>
                    </a>
                    <a href="{{ url($event->page->getActualPageInstanceAttribute()->slug) }}" class="tl d-block">
                        {{ $event->name }}</a>
                    <span class="time d-block"><i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($event->start_time)->format('h:ia') }}</span>
                    <span class="row">
                        <span class="col-7">
                            <span class="place"><i class="fal fa-map-marker-alt"></i>{{ $event->location }}</span>
                        </span>
                        <span class="col-5 text-right">
                            <span class="date">{{ $event->start_date->format('M') }}<span>{{ $event->start_date->format('d') }}</span></span>
                        </span>
                    </span>
                </div>
            @endforeach
        </div>
        <div class="pagination justify-content-center">
            {{ $events->appends(request()->except('page'))->links() }}
        </div>
    </div>
</section>

@include('modules.presentation.islamic_help_needs_you', [
    'parameters' => $parameters
])

@include('modules.presentation.join_the_cause_subscribe3', [
    'parameters' => $parameters
])

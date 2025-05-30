@php

    $campaignCategories = \App\Models\Project::getProjectCampaignsCateg($pageInstance);

    $showPriceHandlersOnly = $priceHandlersOnly ?? false;
    $donateImg = '';
    $donateVideo = '';
    $donateText = '';

    if (isset($parameters['donate_img'])) {
        $donateImg = $parameters['donate_img'];
    }

    if (isset($parameters['donate_video'])) {
        $donateVideo = $parameters['donate_video'];
    }

    if (isset($parameters['donate_text'])) {
        $donateText = $parameters['donate_text'];
    }

    if (!isset($isEmergency)) {
        $isEmergency = false;
    }

    if (isset($colorInfo) && !$isEmergency) {
        $isColorInfo = true;
    }

@endphp

@php

    $amount = [];

    if (isset($parameters['amount'])) {
        $amount = $parameters['amount'];
    }

    $campaignsCountries = [];

    foreach ($amount as $key => $item) {
        if (isset($item['campaigns'])) {
            $campaigns = [];
            foreach ($item['campaigns'] as $campId) {
                $campName = \App\Models\Campaign::getCountryNameForPrice($campId, $item['value'], $item['type']);

                if (isset($campName)) {
                    $campaigns[$campId] = $campName;
                }
            }
            $campaignsCountries[$key] = $campaigns;
        }

        if (isset($item['type']) && ((int) $item['type']) === \App\Models\CampaignPrice::TYPE_SINGLE) {
            $useSingleTab = true;
        }

        if (isset($item['type']) && ((int) $item['type']) === \App\Models\CampaignPrice::TYPE_MONTHLY) {
            $useMonthlyTab = true;
        }
    }

    $allCategories = \App\Models\CampaignCategory::all();
    $swipifyWidgetId = "";
    $swipifyWidgetToken = "";
    if (isset($parameters['swipify_widget_id'])) {
        $swipifyWidgetId = $parameters['swipify_widget_id'];
    }

    if (isset($parameters['swipify_widget_token'])) {
        $swipifyWidgetToken = $parameters['swipify_widget_token'];
    }
    $showPaymentWidget = strlen($swipifyWidgetId) > 0 && strlen($swipifyWidgetToken) > 0;
    if (isset($isWinter2024Page) && $isWinter2024Page) {
         unset($useMonthlyTab);
    } else {
        $isWinter2024Page = false;
    }
    if(!isset($isOrphanCarePage)) {
        $isOrphanCarePage = false;
    }
@endphp

@if($showPriceHandlersOnly)
    <div class="donate-today">
    <div class="body">
    <div class="donate-today-sheet">
        <nav>
            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                @isset($useSingleTab)
                    <a class="nav-link @isset($isColorInfo) color-info @endisset @if ($isEmergency) color-red @endif active"
                       run-trigger="click" data-toggle="tab" href="#nav-1" role="tab" donate-filter
                       data-filter="single" aria-selected="true">Single</a>
                @endisset
                @isset($useMonthlyTab)
                    <a class="nav-link @isset($isColorInfo) color-info @endisset @if ($isEmergency) color-red @endif "
                       data-toggle="tab" href="#nav-2" role="tab" donate-filter data-filter="monthly"
                       aria-selected="false">Monthly</a>
                @endisset
                @isset($useAppeal)
                    <a class="nav-link color-red" data-toggle="tab" href="#nav-3" role="tab" donate-filter
                       data-filter="appeal" aria-selected="false">Appeal</a>
                @endisset
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">

            @isset($useSingleTab)
                <div class="tab-pane fade show active" id="nav-1" role="tabpanel">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        @include('modules.presentation.parts.donate_options', [
                            'donateOptionsType' => \App\Models\CampaignPrice::TYPE_SINGLE,
                             'isWinter2024Page' => $isWinter2024Page
                        ])

                        <input type="hidden" value="single" name="period" />

                        <div class="pt-3"></div>
                        <div class="form-group" currency="£">
                            <input name="amount" type="number" class="form-control" placeholder="Enter amount"
                                   oninput="this.value = Math.abs(this.value)" min="5">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="categories">
                                {{-- will be replaced by js --}}
                                @foreach ($allCategories as $category)
                                    <option value="{{ $category->name }}"> {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group d-none">
                            @include('modules.presentation.parts.currency_selector')
                        </div>

                        <div class="pt-3"></div>
                        @if (!empty($parameters['countries_image']))
                            <div class="text-center pb-3">
                                <a class="text-dark open-modal-countries-price">tap here to see all countries and their
                                    prices</a>
                            </div>
                        @endif
                        <div class="text-center">
                            <button
                                class="btn @isset($isColorInfo) btn-info @else btn-danger @endisset border-white btn-submit w-100"
                                donate-btn>Donate now</button>
                        </div>
                    </form>
                </div>
            @endisset

            @isset($useMonthlyTab)
                <div class="tab-pane fade" id="nav-2" role="tabpanel">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        @include('modules.presentation.parts.donate_options', [
                            'donateOptionsType' => \App\Models\CampaignPrice::TYPE_MONTHLY,
                        ])
                        <input type="hidden" value="monthly" name="period" />
                        <input type="hidden" value="" name="goal" />
                        <div class="pt-3"></div>
                        <div class="form-group" currency="£">
                            <input name="amount" type="number" class="form-control" placeholder="Enter amount"
                                   oninput="this.value = Math.abs(this.value)" min="5">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="categories">
                                {{-- will be replaced by js --}}
                                @foreach ($allCategories as $category)
                                    <option value="{{ $category->name }}"> {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group d-none">
                            @include('modules.presentation.parts.currency_selector')
                        </div>
                        <div class="pt-3"></div>
                        @if (!empty($parameters['countries_image']))
                            <div class="text-center pb-3">
                                <a class="text-dark open-modal-countries-price">tap here to see all countries and their
                                    prices</a>
                            </div>
                        @endif
                        <div class="text-center">
                            <button
                                class="btn @isset($isColorInfo) btn-info @else btn-danger @endisset border-white btn-submit w-100"
                                donate-btn>Donate now</button>
                        </div>
                    </form>
                </div>
            @endisset

            @isset($useAppeal)
                <div class="tab-pane fade" id="nav-3" role="tabpanel">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <div class="pb-2">
                            <button type="button" select-appeal-tab data-tab="tab_single"
                                    class="btn btn-danger btn_appeal_tab">Single</button>
                            <button type="button" select-appeal-tab data-tab="tab_monthly"
                                    class="btn btn-danger btn_appeal_tab">Regular</button>
                        </div>

                        <div class="tab_single" appeal-tab>
                            @include('modules.presentation.parts.donate_options', [
                                'donateOptionsType' => \App\Models\CampaignPrice::TYPE_SINGLE,
                                'class' => 'active-color-red',
                            ])
                        </div>

                        <div class="tab_monthly d-none" appeal-tab>
                            @include('modules.presentation.parts.donate_options', [
                                'donateOptionsType' => \App\Models\CampaignPrice::TYPE_MONTHLY,
                                'class' => 'active-color-red',
                            ])
                        </div>

                        <div class="pt-3"></div>
                        <div class="form-group" currency="£">
                            <input name="amount" type="number" class="form-control" placeholder="Enter amount"
                                   oninput="this.value = Math.abs(this.value)" min="5">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="categories">
                                {{-- will be replaced by js --}}
                                @foreach ($allCategories as $category)
                                    <option value="{{ $category->name }}"> {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group d-none">
                            @include('modules.presentation.parts.currency_selector')
                        </div>
                        <div class="pt-3"></div>
                        @if (!empty($parameters['countries_image']))
                            <div class="text-center pb-3">
                                <a class="text-dark open-modal-countries-price">tap here to see all countries and their
                                    prices</a>
                            </div>
                        @endif
                        <div class="text-center">
                            <button class="btn btn-danger border-white btn-submit w-100" donate-btn>Donate now</button>
                        </div>
                    </form>
                </div>
            @endisset
        </div>
    </div>
    </div>
    </div>
@else
<div class="black-line"></div>
<div class="body">
    <div id="donate_module_options" class="alert alert-warning d-none">
        {{ json_encode($campaignCategories) }}
    </div>

    @empty($donateVideo)
        <div class="media donation">
            @empty($donateImg)
                <img src="img/content/donate-today-1.jpg" alt="" class="w-100">
            @else
                <img src="{{ $donateImg }}" alt="" class="w-100">
            @endempty
        </div>
        <div class="media appeal d-none">
            <img src="img/content/values-action-4.jpg" alt="" class="w-100">
        </div>
    @else
        <div class="media img-video videoWrapper" style="background: #555">
            <div class="video-poster">
                <button class="video-poster__play video-poster__play--top-right"
                    data-url="https://www.youtube.com/embed/{{ $donateVideo }}"><i class="ico-play"></i></button>
                <img class="video-poster__img" src="https://img.youtube.com/vi/{{ $donateVideo }}/maxresdefault.jpg">
            </div>
            <iframe width="1280" height="720" src="https://www.youtube.com/embed/{{ $donateVideo }}" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
        </div>
    @endempty

    <!-- @empty($donateText)
    <div class="mb-5 font-size-18 letter-spacing-0 donate-text">
            <b class="font-weight-sb">
                Every donation, no matter how small, will help empower and uplift someone in need. Make a difference today.
            </b>
        </div>
@else
    <div class="mb-5 font-size-18 letter-spacing-0 donate-text"><b class="font-weight-sb">{{ $donateText }}</b></div>
@endempty -->

    <style>
        .donate-today-sheet--with-widget {
            padding-top: 40px !important;
        }
        .payment-widget {
        }

        .payment-widget__decor {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .payment-widget__title {
            text-align: center;
            font-size: 24px;
            font-weight: 900;
            margin-bottom: 16px;
            text-transform: uppercase;
        }
    </style>
    @if($showPaymentWidget)
        <div class="payment-widget">
            <h2 class="payment-widget__title">Donate with a quick swipe</h2>
            <div class="payment-widget__container">
                <div id="SwipifyWidgetApp"></div>
                <script>
                    window.SwipifyAsyncInit = function() {
                        window.SF = {
                            id: {{ $swipifyWidgetId }},
                            token: '{{ $swipifyWidgetToken }}'
                        };
                    };
                </script>
                <script async defer src="https://app.swipify.io/static/sdk/swipify-form.min.js"></script>
            </div>
            <div class="payment-widget__decor">
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
        </div>
    @endif
    <h1 class="donate-today__title">Donate today</h1>

    <div class="black-line"></div>

    <div class="donate-today-sheet">
        <nav>
            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                @isset($useSingleTab)
                    <a class="nav-link @if(!$isOrphanCarePage) active @endif @isset($isColorInfo) color-info @endisset @if ($isEmergency) color-red @endif"
                        data-toggle="tab" href="#nav-1" role="tab" donate-filter
                        data-filter="single" aria-selected="true">Single</a>
                @endisset
                @isset($useMonthlyTab)
                    <a class="nav-link @if($isOrphanCarePage) active @endif @isset($isColorInfo) color-info @endisset @if ($isEmergency) color-red @endif "
                        data-toggle="tab" href="#nav-2" role="tab" donate-filter data-filter="monthly"
                        aria-selected="false">Monthly</a>
                @endisset
                @isset($useAppeal)
                    <a class="nav-link color-red" data-toggle="tab" href="#nav-3" role="tab" donate-filter
                        data-filter="appeal" aria-selected="false">Appeal</a>
                @endisset
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">

            @isset($useSingleTab)
                <div class="tab-pane fade  @if(!$isOrphanCarePage) show active @endif" id="nav-1" role="tabpanel">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        @include('modules.presentation.parts.donate_options', [
                            'donateOptionsType' => \App\Models\CampaignPrice::TYPE_SINGLE,
                        ])

                        <input type="hidden" value="single" name="period" />

                        <div class="pt-3"></div>
                        <div class="form-group" currency="£">
                            <input name="amount" type="number" class="form-control" placeholder="Enter amount"
                                oninput="this.value = Math.abs(this.value)" min="5">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="categories">
                                {{-- will be replaced by js --}}
                                @foreach ($allCategories as $category)
                                    <option value="{{ $category->name }}"> {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group d-none">
                            @include('modules.presentation.parts.currency_selector')
                        </div>

                        <div class="pt-3"></div>
                        @if (!empty($parameters['countries_image']))
                            <div class="text-center pb-3">
                                <a class="text-dark open-modal-countries-price">tap here to see all countries and their prices</a><br>
                                @if(strtolower($pageInstance->slug) === 'qurbani-2025-3')
                                    <span>Select quantities in the cart after tapping Donate Now</span>
                                @endif
                            </div>
                        @endif
                        <div class="text-center">
                            <button
                                class="btn @isset($isColorInfo) btn-info @else btn-danger @endisset border-white btn-submit w-100"
                                donate-btn>Donate now</button>
                        </div>
                    </form>
                </div>
            @endisset

            @isset($useMonthlyTab)
                <div class="tab-pane fade @if($isOrphanCarePage) show active @endif" id="nav-2" role="tabpanel">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        @include('modules.presentation.parts.donate_options', [
                            'donateOptionsType' => \App\Models\CampaignPrice::TYPE_MONTHLY,
                        ])
                        <input type="hidden" value="monthly" name="period" />
                        <input type="hidden" value="" name="goal" />
                        <div class="pt-3"></div>
                        <div class="form-group" currency="£">
                            <input name="amount" type="number" class="form-control" placeholder="Enter amount"
                                oninput="this.value = Math.abs(this.value)" min="5">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="categories">
                                {{-- will be replaced by js --}}
                                @foreach ($allCategories as $category)
                                    <option value="{{ $category->name }}"> {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group d-none">
                            @include('modules.presentation.parts.currency_selector')
                        </div>
                        <div class="pt-3"></div>
                        @if (!empty($parameters['countries_image']))
                            <div class="text-center pb-3">
                                <a class="text-dark open-modal-countries-price">tap here to see all countries and their prices</a>
                            </div>
                        @endif
                        <div class="text-center">
                            <button
                                class="btn @isset($isColorInfo) btn-info @else btn-danger @endisset border-white btn-submit w-100"
                                donate-btn>Donate now</button>
                        </div>
                    </form>
                </div>
            @endisset

            @isset($useAppeal)
                <div class="tab-pane fade" id="nav-3" role="tabpanel">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <div class="pb-2">
                            <button type="button" select-appeal-tab data-tab="tab_single"
                                class="btn btn-danger btn_appeal_tab">Single</button>
                            <button type="button" select-appeal-tab data-tab="tab_monthly"
                                class="btn btn-danger btn_appeal_tab">Regular</button>
                        </div>

                        <div class="tab_single" appeal-tab>
                            @include('modules.presentation.parts.donate_options', [
                                'donateOptionsType' => \App\Models\CampaignPrice::TYPE_SINGLE,
                                'class' => 'active-color-red',
                            ])
                        </div>

                        <div class="tab_monthly d-none" appeal-tab>
                            @include('modules.presentation.parts.donate_options', [
                                'donateOptionsType' => \App\Models\CampaignPrice::TYPE_MONTHLY,
                                'class' => 'active-color-red',
                            ])
                        </div>

                        <div class="pt-3"></div>
                        <div class="form-group" currency="£">
                            <input name="amount" type="number" class="form-control" placeholder="Enter amount"
                                oninput="this.value = Math.abs(this.value)" min="5">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="categories">
                                {{-- will be replaced by js --}}
                                @foreach ($allCategories as $category)
                                    <option value="{{ $category->name }}"> {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group d-none">
                            @include('modules.presentation.parts.currency_selector')
                        </div>
                        <div class="pt-3"></div>
                        @if (!empty($parameters['countries_image']))
                            <div class="text-center pb-3">
                                <a class="text-dark open-modal-countries-price">tap here to see all countries and their
                                    prices</a>
                            </div>
                        @endif
                        <div class="text-center">
                            <button class="btn btn-danger border-white btn-submit w-100" donate-btn>Donate now</button>
                        </div>
                    </form>
                </div>
            @endisset
        </div>
    </div>
</div>
@endif

@if (!empty($parameters['countries_image']))
    <script>
        $(document).on("click", ".open-modal-countries-price", function() {
            $(".modal-countries-price").modal("show");
        });
    </script>

    <div class="modal modal-countries-price" id="countriesPriceModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" style="background: #aaa" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <img style="max-width: 100%;margin-top: 10px;" class="img-responsive"
                        src="{{ $parameters['countries_image'] }}">
                </div>
            </div>
        </div>
    </div>
@endif

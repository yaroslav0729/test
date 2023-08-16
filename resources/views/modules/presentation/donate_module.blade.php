@php

    $campaignCategories = \App\Models\Project::getProjectCampaignsCateg($pageInstance);

    $donateImg = "";
    $donateVideo = "";
    $donateText = "";

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

    if ((isset($colorInfo)) && (!$isEmergency)) {
        $isColorInfo = true;
    }

@endphp

@php

$amount = [];

if (isset($parameters['amount'])) {
    $amount = $parameters['amount'];
}

$campaignsCountries = \App\Models\Project::getProjectCampaignsCountries($pageInstance);

//dd($campaignsCountries, $pageInstance->parameters['amount']);

foreach ($amount as $key => $item) {
    if ((isset($item['type'])) && ((int)$item['type']) === \App\Models\CampaignPrice::TYPE_SINGLE) {
        $useSingleTab = true;
    }

    if ((isset($item['type'])) && ((int)$item['type']) === \App\Models\CampaignPrice::TYPE_MONTHLY) {
        $useMonthlyTab = true;
    }
}

$allCategories = \App\Models\CampaignCategory::all();

@endphp

@php

$col1Class = 'col-12 col-lg-6';
$col2Class = 'col-12 col-lg-6';

if (!isset($useAppeal)) {
    $col1Class = 'col-12 col-lg-7';
    $col2Class = 'col-12 col-lg-5';
}

@endphp

<div class="body">
    <div id="donate_module_options" class="alert alert-warning d-none">
        {{ json_encode($campaignCategories) }}
    </div>
    <div class="row gutter-0">
        <div class="{{ $col1Class }}">

            @empty($donateVideo)
                @empty($donateImg)
                    <div class="media donation" style="background-image: url(img/content/donate-today-1.jpg);">
                    <img src="" alt="" class="w-100">
                @else
                    <div class="media" style="background-image: url({{ $donateImg }});">
                @endempty
                </div>
                <div class="media appeal d-none" style="background-image: url(img/content/values-action-4.jpg);"></div>
            @else
                <div class="media img-video videoWrapper" style="background: #555">
                    <div class="video-poster">
                        <button class="video-poster__play video-poster__play" data-url="https://www.youtube.com/embed/{{ $donateVideo }}"><i class="ico-play"></i></button>
                        <img class="video-poster__img" src="https://img.youtube.com/vi/{{ $donateVideo }}/maxresdefault.jpg">
                    </div>
                    <iframe width="1280" height="720" src="https://www.youtube.com/embed/{{ $donateVideo }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            @endempty

            <!-- <div class="descr">
                <div>
                    @empty($donateText)
                        Every donation, no matter how small, will help empower and uplift someone in need. Make a difference today.
                    @else
                        {{ $donateText }}
                    @endempty
                </div>
            </div> -->
        </div>
        <div class="{{ $col2Class }}">
            {{--            if 1-2 tabs - col-5--}}
            <div class="donate-today-sheet">

                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        @isset($useSingleTab)
                        <a run-trigger="click" class="nav-link active @isset($isColorInfo) color-info @endisset @if($isEmergency) color-red @endif"  data-toggle="tab" href="#nav-1" role="tab" aria-selected="true" donate-filter data-filter="single">Single Donation</a>
                        @endisset
                        @isset($useMonthlyTab)
                        <a class="nav-link @isset($isColorInfo) color-info @endisset @if($isEmergency) color-red @endif @empty($useSingleTab) active @endempty"  data-toggle="tab" href="#nav-2" role="tab"  aria-selected="false" donate-filter data-filter="monthly">Monthly Donation</a>
                        @endisset
                        @isset($useAppeal)
                        <a class="nav-link color-red"  data-toggle="tab" href="#nav-3" role="tab"  aria-selected="false" donate-filter data-filter="appeal">Appeal Donation</a>
                        @endisset
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    @isset($useSingleTab)
                    <div class="tab-pane fade show active" id="nav-1" role="tabpanel" >
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            @include('modules.presentation.parts.donate_options',[
                                'donateOptionsType' => \App\Models\CampaignPrice::TYPE_SINGLE
                            ])

                            <input type="hidden" value="single" name="period" />

                            <div class="pt-3"></div>
                            <div class="row gutter-5 select-container">
                                <div class="col-5 category-col">
                                    <div class="form-group">
                                        <select class="form-control" name="categories">
                                            {{-- will be replaced by js --}}
                                            @foreach($allCategories as $category)
                                                <option value="{{ $category->name }}"> {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4 amount-col">
                                    <div class="form-group" currency="£">
                                        <input name="amount" type="number" class="form-control" placeholder="Enter amount" oninput="this.value = Math.abs(this.value)" min="5">
                                    </div>
                                </div>
                                <div class="col-3 currency-col">
                                    <div class="form-group">
                                        @include('modules.presentation.parts.currency_selector')
                                    </div>
                                </div>
                            </div>
                            <div class="pt-3"></div>
                            @if(!empty($parameters['countries_image']))
                            <div class="text-center pb-3">
                                <a class="text-dark open-modal-countries-price">tap here to see all countries and their prices</a>
                            </div>
                            @endif
                            <div class="text-center">
                                <button type="button" class="btn @isset($isColorInfo) btn-info @else btn-danger @endisset border-white btn-submit"
                                donate-btn
                                >Donate now</button>
                            </div>
                        </form>
                    </div>
                    @endisset
                    @isset($useMonthlyTab)
                    <div class="tab-pane fade @empty($useSingleTab) show active @endempty" id="nav-2" role="tabpanel" >
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf

                            @include('modules.presentation.parts.donate_options',[
                                'donateOptionsType' => \App\Models\CampaignPrice::TYPE_MONTHLY,
                            ])

                            <input type="hidden" value="monthly" name="period" />

                            <div class="pt-3"></div>
                            <div class="row gutter-5 select-container">
                                <div class="col-5 category-col">
                                    <div class="form-group">
                                        <select class="form-control" name="categories">
                                            {{-- will be replaced by js --}}
                                            @foreach($allCategories as $category)
                                                <option value="{{ $category->name }}"> {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4 amount-col">
                                    <div class="form-group" currency="£">
                                        <input name="amount" type="number" class="form-control" placeholder="Enter amount" oninput="this.value = Math.abs(this.value)" min="5">
                                    </div>
                                </div>
                                <div class="col-3 currency-col">
                                    <div class="form-group">
                                        @include('modules.presentation.parts.currency_selector')
                                    </div>
                                </div>
                            </div>
                            <div class="pt-3"></div>
                            @if(!empty($parameters['countries_image']))
                                <div class="text-center pb-3">
                                    <a class="text-dark open-modal-countries-price">tap here to see all countries and their prices</a>
                                </div>
                            @endif
                            <div class=
                            <div class="text-center">
                                <button type="button" class="btn @isset($isColorInfo) btn-info @else btn-danger @endisset @if($isEmergency) btn-danger @endif border-white btn-submit"
                                donate-btn
                                >Donate now</button>
                            </div>
                        </form>
                    </div>
                    @endisset
                    @isset($useAppeal)
                    <div class="tab-pane fade" id="nav-3" role="tabpanel" >
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf

                            <input type="hidden" value="single" name="period" />

                            <div class="period-switcher-wrapper">
                                <div class="period-switcher">
                                    <button type="button" select-appeal-tab data-period="single" data-tab="tab_single" class="btn btn_appeal_tab single active">Single</button>
                                    <button type="button" select-appeal-tab data-period="monthly" data-tab="tab_monthly" class="btn btn_appeal_tab monthly">Monthly</button>
                                </div>
                            </div>

                            <div class="tab_single" appeal-tab>
                            @include('modules.presentation.parts.donate_options',[
                                'donateOptionsType' => \App\Models\CampaignPrice::TYPE_SINGLE,
                                'class' => 'active-color-red'
                            ])
                            </div>

                            <div class="tab_monthly d-none" appeal-tab>
                            @include('modules.presentation.parts.donate_options',[
                                'donateOptionsType' => \App\Models\CampaignPrice::TYPE_MONTHLY,
                                'class' => 'active-color-red'
                            ])
                            </div>

                            <div class="pt-3"></div>
                            @if(!empty($parameters['countries_image']))
                                <div class="text-center pb-3">
                                    <a class="text-dark open-modal-countries-price">tap here to see all countries and their prices</a>
                                </div>
                            @endif
                            <div class="row gutter-5 select-container">
                                <div class="col-5 category-col">
                                    <div class="form-group">
                                        <select class="form-control" name="categories">
                                            {{-- will be replaced by js --}}
                                            @foreach($allCategories as $category)
                                                <option value="{{ $category->name }}"> {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4 amount-col">
                                    <div class="form-group" currency="£">
                                        <input name="amount" type="number" class="form-control" placeholder="Enter amount" oninput="this.value = Math.abs(this.value)" min="5">
                                    </div>
                                </div>
                                <div class="col-3 currency-col">
                                    <div class="form-group">
                                        @include('modules.presentation.parts.currency_selector')
                                    </div>
                                </div>
                            </div>
                            <div class="pt-3"></div>
                            <div class="text-center">
                                <button type="button" class="btn btn-danger border-white btn-submit"
                                donate-btn
                                >Donate now</button>
                            </div>
                        </form>
                    </div>
                    @endisset
                </div>
            </div>
        </div>

    </div>
</div>
    @if(!empty($parameters['countries_image']))
        <script>
            $(document).on("click", ".open-modal-countries-price", function () {
                $(".modal-countries-price").modal("show");
            });
        </script>

        <div class="modal modal-countries-price" id="countriesPriceModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" style="background: #aaa" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <img style="max-width: 100%;margin-top: 10px;" class="img-responsive" src="{{ $parameters['countries_image'] }}">
                    </div>
                </div>
            </div>
        </div>
@endif

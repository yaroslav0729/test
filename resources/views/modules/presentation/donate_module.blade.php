@php

    $campaignCategories = \App\Models\Project::getProjectCampaignsCateg($pageInstance);

    $donateImg = "";
    $donateText = "";

    if (isset($parameters['donate_img'])) {
        $donateImg = $parameters['donate_img'];    
    }

    if (isset($parameters['donate_text'])) {
        $donateText = $parameters['donate_text'];    
    }

    if (!isset($isEmergency)) $isEmergency = false;

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
            
            if (isset($campName))
            $campaigns[$campId] = $campName;
        }
        $campaignsCountries[$key] = $campaigns; 
    }

    if ((isset($item['type'])) && ((int)$item['type']) === \App\Models\CampaignPrice::TYPE_SINGLE) {
        $useSingleTab = true;
    }

    if ((isset($item['type'])) && ((int)$item['type']) === \App\Models\CampaignPrice::TYPE_MONTHLY) {
        $useMonthlyTab = true;
    }
}

@endphp

<div class="body">
    <div id="donate_module_options" class="alert alert-warning d-none">
        {{ json_encode($campaignCategories) }}
    </div>
    <div class="row gutter-0">
        <div class="col-6">
            <div class="media">
                @empty($donateImg)
                    <img src="img/content/donate-today-1.jpg" alt="" class="w-100">
                @else
                    <img src="{{ $donateImg }}" alt="" class="w-100">
                @endempty
            </div>
        </div>
        <div class="col-6">
            <div class="donate-today-sheet">

                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        @isset($useSingleTab)
                        <a run-trigger="click" class="nav-link active @if($isEmergency) color-red @endif"  data-toggle="tab" href="#nav-1" role="tab" aria-selected="true" donate-filter data-filter="single">Single Donation</a>
                        @endisset
                        @isset($useMonthlyTab)
                        <a class="nav-link @if($isEmergency) color-red @else color-info @endif @empty($useSingleTab) active @endempty"  data-toggle="tab" href="#nav-2" role="tab"  aria-selected="false" donate-filter data-filter="monthly">Monthly Donation</a>
                        @endisset
                        @isset($useAppeal)
                        <a class="nav-link color-red"  data-toggle="tab" href="#nav-3" role="tab"  aria-selected="false" donate-filter data-filter="appeal">Appeal Donation</a>
                        @endisset
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    @isset($useSingleTab)
                    <div class="tab-pane fade show active" id="nav-1" role="tabpanel" >
                        <form action="/">

                            @include('modules.presentation.parts.donate_options',[
                                'donateOptionsType' => \App\Models\CampaignPrice::TYPE_SINGLE
                            ])                        

                            <div class="pt-3"></div>
                            <div class="row gutter-5">
                                <div class="col-6">
                                    <div class="form-group">
                                        <select class="form-control" name="categories">
                                            {{-- will be replaced by js --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group" currency="£">
                                        <input name="amount" type="number" class="form-control" placeholder="Enter amount">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        @include('modules.presentation.parts.currency_selector')
                                    </div>
                                </div>
                            </div>
                            <div class="pt-3"></div>
                            <div class="text-center">
                                <button type="button" class="btn btn-danger border-white btn-submit"
                                donate-btn
                                >Donate</button>
                            </div>
                        </form>
                    </div>
                    @endisset 
                    @isset($useMonthlyTab)
                    <div class="tab-pane fade @empty($useSingleTab) show active @endempty" id="nav-2" role="tabpanel" >
                        <form action="/">

                            @include('modules.presentation.parts.donate_options',[
                                'donateOptionsType' => \App\Models\CampaignPrice::TYPE_MONTHLY,
                                'class' => 'active-color-info'
                            ])

                            <div class="pt-3"></div>
                            <div class="row gutter-5">
                                <div class="col-6">
                                    <div class="form-group">
                                        <select class="form-control" name="categories">
                                            {{-- will be replaced by js --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group" currency="£">
                                        <input name="amount" type="number" class="form-control" placeholder="Enter amount">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        @include('modules.presentation.parts.currency_selector')
                                    </div>
                                </div>
                            </div>
                            <div class="pt-3"></div>
                            <div class="text-center">
                                <button type="button" class="btn @if($isEmergency) btn-danger @else btn-info @endif border-white btn-submit"
                                donate-btn
                                >Donate</button>
                            </div>
                        </form>
                    </div>
                    @endisset 
                    @isset($useAppeal)
                    <div class="tab-pane fade" id="nav-3" role="tabpanel" >
                        <form action="/">

                            <div class="pb-2">
                            <button type="button" select-appeal-tab data-tab="tab_single" class="btn btn-danger btn_appeal_tab">Single</button>
                            <button type="button" select-appeal-tab data-tab="tab_monthly" class="btn btn-danger btn_appeal_tab">Regular</button>
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
                            <div class="row gutter-5">
                                <div class="col-6">
                                    <div class="form-group">
                                        <select class="form-control" name="categories">
                                            {{-- will be replaced by js --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group" currency="£">
                                        <input name="amount" type="number" class="form-control" placeholder="Enter amount">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        @include('modules.presentation.parts.currency_selector')
                                    </div>
                                </div>
                            </div>
                            <div class="pt-3"></div>
                            <div class="text-center">
                                <button type="button" class="btn btn-danger border-white btn-submit"
                                donate-btn
                                >Donate</button>
                            </div>
                        </form>
                    </div>
                    @endisset
                </div>
            </div>
        </div>
        <div class="descr"><div>
            @empty($donateText)
                Your subtitle/copy can go here, max of 100ch ut perspi unde omnis iste natus demiour sit voluptatem, abilloum inventore.
            @else 
                {{ $donateText }}
            @endempty
        </div></div>

    </div>

    @include('modules.presentation.parts.donate_modal')
</div>
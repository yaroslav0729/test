@php

    $donateImg = "";
    $donateText = "";

    if (isset($parameters['donate_img'])) {
        $donateImg = $parameters['donate_img'];    
    }

    if (isset($parameters['donate_text'])) {
        $donateText = $parameters['donate_text'];    
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
            $campaigns[$campId] = \App\Models\Campaign::getCountryNameByCampaignId($campId);
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
    <div class="media">
        @empty($donateText)
        <img src="img/content/donate-today-1.jpg" alt="" class="w-100">
        @else
        <img src="{{ $donateImg }}" alt="" class="w-100"> 
        @endempty
    </div>

    @empty($donateText)
    <div class="mb-5 font-size-18">Your subtitle/copy can go here, max of 100ch ut perspi unde omnis iste natus demiour sit voluptatem, abilloum inventore.</div>
    @else
    <div class="mb-5 font-size-18">{{ $donateText }}</div>
    @endempty

    <div class="black-line"></div>
    <div class="pt-5"></div>

    <div class="donate-today-sheet">
        <nav>
            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                @isset($useSingleTab)
                <a class="nav-link color-info active"  data-toggle="tab" href="#nav-1" role="tab" aria-selected="true">Single</a>
                @endisset
                @isset($useMonthlyTab)
                <a class="nav-link color-info"  data-toggle="tab" href="#nav-2" role="tab"  aria-selected="false">Monthly</a>
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
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="£  Enter amount">
                    </div>
                    <div class="form-group">
                        <select class="form-control">
                            <option value="1">General Charity</option>
                            <option value="1">General Charity 2</option>
                        </select>
                    </div>
                    <div class="pt-3"></div>
                    <div class="text-center">
                        <button class="btn btn-info border-white btn-submit w-100">Donate</button>
                    </div>
                </form>
            </div>
            @endisset

            @isset($useMonthlyTab)
            <div class="tab-pane fade" id="nav-2" role="tabpanel" >
                <form action="/">

                    @include('modules.presentation.parts.donate_options',[
                        'donateOptionsType' => \App\Models\CampaignPrice::TYPE_MONTHLY
                    ])

                    <div class="pt-3"></div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="£  Enter amount">
                    </div>
                    <div class="form-group">
                        <select class="form-control">
                            <option value="1">General Charity</option>
                            <option value="1">General Charity 2</option>
                        </select>
                    </div>
                    <div class="pt-3"></div>
                    <div class="text-center">
                        <button class="btn btn-info border-white btn-submit w-100">Donate</button>
                    </div>
                </form>
            </div>
            @endisset
        </div>
    </div>
</div>
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
                        <a class="nav-link active"  data-toggle="tab" href="#nav-1" role="tab" aria-selected="true" donate-filter data-filter="single">Single Donation</a>
                        @endisset
                        @isset($useMonthlyTab)
                        <a class="nav-link color-info"  data-toggle="tab" href="#nav-2" role="tab"  aria-selected="false" donate-filter data-filter="monthly">Monthly Donation</a>
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
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="£  Enter amount">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <select class="form-control">
                                            <option value="1">GBP</option>
                                            <option value="2">USD</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-3"></div>
                            <div class="text-center">
                                <button class="btn btn-danger border-white btn-submit">Donate</button>
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
                            <div class="row gutter-5">
                                <div class="col-6">
                                    <div class="form-group">
                                        <select class="form-control" name="categories">
                                            {{-- will be replaced by js --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="£  Enter amount">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <select class="form-control">
                                            <option value="1">GBP</option>
                                            <option value="2">USD</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-3"></div>
                            <div class="text-center">
                                <button class="btn btn-info border-white btn-submit">Donate</button>
                            </div>
                        </form>
                    </div>
                    @endisset 
                    @isset($useAppeal)
                    <div class="tab-pane fade" id="nav-3" role="tabpanel" >
                        <form action="/">
                            
                            @foreach ($amount as $item)
                                <label class="item">
                                    <input type="radio" name="r1">
                                    <span class="d-flex align-items-center">
                                        <span><span>£<b>@isset($item['value']) {{ $item['value'] }} @endisset</b></span><span>JUST ONCE</span></span>
                                        <span>@isset($item['text']) {{ $item['text'] }} @endisset</span>
                                    </span>
                                </label>
                            @endforeach

                            <div class="pt-3"></div>
                            <div class="row gutter-5">
                                <div class="col-6">
                                    <div class="form-group">
                                        <select class="form-control">
                                            <option value="1">General Charity</option>
                                            <option value="1">General Charity 2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="£  Enter amount">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <select class="form-control">
                                            <option value="1">GBP</option>
                                            <option value="2">USD</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-3"></div>
                            <div class="text-center">
                                <button class="btn btn-danger border-white btn-submit">Donate</button>
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
</div>
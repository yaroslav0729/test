@php

$moduleTitle = "";

    if (isset($parameters['still_need_title'])) {
        $moduleTitle = $parameters['still_need_title'];    
    }

    $singleItems = [];

    $amount = null;

    if (isset($parameters['amount'])) {
        $amount = $parameters['amount'];  
    }

    foreach ($amount as $amountKey => $item) {
        if (isset($item['type']) && ((int)$item['type'] === \App\Models\CampaignPrice::TYPE_SINGLE)) {
            $singleItems[$amountKey] = $item;
        }
    }

    $campaignsCountries = \App\Models\Project::getProjectCampaignsCountries($pageInstance);

    if (!isset($isEmergency)) {
        $isEmergency = false;
    }

@endphp

<section class="donate-today-card">
    <div class="wrap">
        <div class="title">
            @empty($moduleTitle)
            <span>We still need your support.</span>
            @else
            <span>{{ $moduleTitle }}</span>
            @endempty
        </div>

        <div class="list donate-today-card-swiper" swiper-wrapper="we_still_need">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach ($singleItems as $itemKey => $item)
                        @if(count($campaignsCountries[$itemKey])>0) {{-- price exists & ok in campaign --}}
                            <div class="swiper-slide">
                                <div class="item @if($isEmergency) active-color-danger @else active-color-info @endisset">
                                    <div>£<b>{{ $item['value'] }}</b></div>
                                    {{ $item['text'] }}
                                </div>
                            </div>
                        @endif
                    @endforeach
                    
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

    </div>
</section>
{{--

This module depends from donate_module. 
All items - single ptice items from donate module

--}}

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

<section class="donate-today-card" id="still_need_support">
    <div class="wrap">
        <div class="title">
            @empty($moduleTitle)
            <span>We still need your support.</span>
            @else
            <span>{{ $moduleTitle }}</span>
            @endempty
        </div>
        <div class="list d-flex justify-content-center">
            
            @php
                $loopCou = 0;    
            @endphp
            @foreach ($singleItems as $itemKey => $item)

                @if($loopCou==3) 
                    @continue 
                @endif

                @if(count($campaignsCountries[$itemKey])>0) {{-- price exists & ok in campaign --}}
                    <div class="item @if($isEmergency) active-color-danger @else active-color-info @endisset" data-item_num='{{ $itemKey }}'>
                        <div>£<b>{{ $item['value'] }}</b></div>
                        {!! $item['text'] !!}
                    </div>
                @endif 
                
                @php
                    $loopCou++;
                @endphp

            @endforeach
            
        </div>
    </div>
</section>
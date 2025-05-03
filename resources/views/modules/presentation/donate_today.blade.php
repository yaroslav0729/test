{{-- This module depends from donate_module. 
All items - single ptice items from donate module --}}

@php
$moduleTitle = '';

if (isset($parameters['still_need_title'])) {
    $moduleTitle = $parameters['still_need_title'];
}

$singleItems = [];

$amount = null;

if (isset($parameters['amount'])) {
    $amount = $parameters['amount'];
}

foreach ($amount as $amountKey => $item) {
    if (isset($item['type']) && (int) $item['type'] === \App\Models\CampaignPrice::TYPE_SINGLE) {
        $singleItems[$amountKey] = $item;
    }
}

$campaignsCountries = \App\Models\Project::getProjectCampaignsCountries($pageInstance);

if (!isset($isEmergency)) {
    $isEmergency = false;
}
$data=[
    [
        'value' => 25,
        'text' => 'Give 1/7 cow share in India'
    ],
    [
        'value' => 45,
        'text' => 'Give 1/7 cow share in Bangladesh'
    ],
    [
        'value' => 65,
        'text' => 'Give 1/7 cow share in Malaysia'
    ]
]
@endphp

<section class="donate-today-card" id="donate_today">
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
            @for ($i = 0; $i < 3; $i++)
                @if ($loopCou == 3)
                    @continue
                @endif
                <div class="item active-color-info" data-item_num='{{ $i }}'>
                    <div>£<b>{{ $data[$i]['value'] }}</b></div>
                    {{ $data[$i]['text'] }}
                </div>
                @php
                    $loopCou++;
                @endphp
            @endfor
        </div>
    </div>
</section>

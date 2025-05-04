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

if($amount) {
    foreach ($amount as $amountKey => $item) {
        if (isset($item['type']) && (int) $item['type'] === \App\Models\CampaignPrice::TYPE_SINGLE) {
            $singleItems[$amountKey] = $item;
        }
    }
}

$campaignsCountries = \App\Models\Project::getProjectCampaignsCountries($pageInstance);

if (!isset($isEmergency)) {
    $isEmergency = false;
}

@endphp

<section class="donate-today-card" id="donate-today-card">
    <div class="wrap">
        <div class="title">
            @empty($moduleTitle)
                <span>We still need your support.</span>
            @else
                <span>{{ $moduleTitle }}</span>
            @endempty
        </div>
        <div class="list d-flex justify-content-center" style="overflow-x: hidden;">
            @php
                $loopCou = 0;
            @endphp
            @foreach ($singleItems as $itemKey => $item)
                @if ($loopCou == 3)
                    @continue
                @endif
                @if (count($campaignsCountries[$itemKey]) > 0) {{-- price exists & ok in campaign --}}
                    <div class="item donate-today-item @if ($isEmergency) active-color-danger @else active-color-info @endisset" 
                        data-item_num='{{ $itemKey }}' 
                        data-amount='{{ $item['value'] }}' 
                        data-campaign_id='{{ $itemKey }}'
                        data-period='single'
                        data-note='{{ strip_tags($item['text']) }}'
                    >
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

{{-- Hidden form to be populated by JS --}}
<form id="donate-today-hidden-form" action="{{ route('cart.add') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="amount" value="">
    <input type="hidden" name="campaigns" value="">
    <input type="hidden" name="period" value="single">
    <input type="hidden" name="note" value="">
</form>

<script>
    function qurbaniClickHandler(e) {
        e.preventDefault();
            
        let $item = $(this);
        
        let amount = $item.data('amount');
        let campaignId = $item.data('campaign_id');
        let note = $item.data('note');
        let formNote = note ? `Donate Today: ${note}` : 'Donate Today Item';

        let $hiddenForm = $('#donate-today-hidden-form');
        $hiddenForm.find('input[name="amount"]').val(amount);
        $hiddenForm.find('input[name="campaigns"]').val(campaignId);
        $hiddenForm.find('input[name="note"]').val(formNote);

        let formElement = $hiddenForm.get(0);

        if (typeof sendFormAndRefreshCard === 'function') {
            sendFormAndRefreshCard($hiddenForm, true);
        } else {
            console.error('Error: sendFormAndRefreshCard function is not defined. Cannot add item.');
            toastr.error('A critical error occurred. Please contact support.', 'Error');
        }
    }
</script>

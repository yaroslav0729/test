@php

$amounts = [];
$types = [];
$texts = [];

if (isset($parameters['amount'])) {
    $amounts = $parameters['amount'];
}
if (isset($parameters['amount_type'])) {
    $types = $parameters['amount_type'];
}
if (isset($parameters['amount_text'])) {
    $texts = $parameters['amount_text'];
}

@endphp


<div options-container>

    <button type="button" option-add class="btn btn-success mb-3 mt-3">Add ammount</button>
    
    <div class="d-none" option-stub stub-fields>
        @include('templates.form.parts.donation_option', ['donationType' => $donationType])
    </div>
    
    <div options-list>
        @foreach ($amounts as $key => $amount)
            @if($donationType === (int)$types[$key])
                @include('templates.form.parts.donation_option', [
                    'donationType' => $donationType,
                    'donationValue' => (int)$amount,
                    'donationText' => $texts[$key],
                    'optionKey' => $key
                ])  
            @endif
        @endforeach
    </div>
    
</div>
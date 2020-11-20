@php

$amounts = [];

if (isset($parameters['amount'])) {
    $amounts = $parameters['amount'];
}

@endphp


<div options-container>

    <button type="button" option-add class="btn btn-success mb-3 mt-3">Add ammount</button>
    
    <div class="d-none" option-stub stub-fields>
        @include('templates.form.parts.donation_option', ['donationType' => $donationType])
    </div>
    
    <div options-list>
        @foreach ($amounts as $key => $amount)

            @php
                if (isset($amount['value'])) {
                    $value = (int)$amount['value'];
                } else {
                    $value = 0;
                }

                if (isset($amount['type'])) {
                    $type = (int)$amount['type'];
                } else {
                    $type = 0;
                }

                if (isset($amount['text'])) {
                    $text = $amount['text'];
                } else {
                    $text = "";
                }

                if (isset($amount['campaigns'])) {
                    $campaigns = $amount['campaigns'];
                } else {
                    $campaigns = [];
                }

            @endphp

            @if($donationType === $type)
                @include('templates.form.parts.donation_option', [
                    'donationType' => $donationType,
                    'donationValue' => $value,
                    'donationText' => $text,
                    'donationCampaigns' => $campaigns,
                    'optionKey' => $key
                ])  
            @endif
        @endforeach
    </div>
    
</div>
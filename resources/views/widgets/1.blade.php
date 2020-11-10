@php
    $quote = "";
    $reference = "";

    if (isset($parameters[0])) {
        $quote = $parameters[0];    
    }

    if (isset($parameters[1])) {
        $reference = $parameters[1];    
    }

@endphp

<div class="blockquote">
    <i>"{{ $quote }}"</i>
    <div>{{ $reference }}</div>
</div>
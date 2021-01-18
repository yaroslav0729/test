@php

    $importantInfoTitle = "";
    $importantInfo = "";

    if (isset($parameters['important_title'])) {
        $importantInfoTitle = $parameters['important_title'];    
    }

    if (isset($parameters['important_text'])) {
        $importantInfo = $parameters['important_text'];    
    }

@endphp

<section class="join-cause">
    <div class="wrap">
        <div class="title mb-5">
            <p class="font-size-30"><b>{{ $importantInfoTitle }}</b></p>
        </div>
        <p class="font-size-16" style="line-height: 26px; font-weight: 500">
            {{ $importantInfo }}
        </p>
    </div>
</section>
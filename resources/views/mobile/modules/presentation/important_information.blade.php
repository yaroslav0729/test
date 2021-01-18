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

<section class="join-cause bg-light">
    <div class="wrap">
        <div class="title mb-2">
        <p class="font-size-16 text-uppercase"><b>{{ $importantInfoTitle }}</b></p>
        </div>
        <p class="font-size-16">
            {{ $importantInfo }}
        </p>
    </div>
</section>

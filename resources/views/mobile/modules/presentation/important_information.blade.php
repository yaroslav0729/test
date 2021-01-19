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


<section class="important-information bg-light">
    <div class="wrap">
        <div class="title mb-2">
            <p class="font-size-16"><b>{{ $importantInfoTitle }}</b></p>
        </div>
        <div class="text">
            <p>{{ $importantInfo }}</p>

            <div class="descr">
                <p>{{ $importantInfo }}</p>
                <p>{{ $importantInfo }}</p>
            </div>
        </div>
        <a href="javascript:void(0)" class="read-more">READ MORE</a>
    </div>
</section>
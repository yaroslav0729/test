@php

    $importantInfoTitle = "";
    $importantInfo = "";
    $importantInfoLong = "";

    if (isset($parameters['important_title'])) {
        $importantInfoTitle = $parameters['important_title'];
    }

    if (isset($parameters['important_text'])) {
        $importantInfo = $parameters['important_text'];
    }

    if (isset($parameters['important_text_long'])) {
        $importantInfoLong = $parameters['important_text_long'];
    }

@endphp

<section class="important-information bg-light">
    <div class="wrap">
        <div class="title mb-5">
            <p class="font-size-30"><b>{{ $importantInfoTitle }}</b></p>
        </div>
        <div class="text">
            <p>{{ $importantInfo }}</p>

            @empty($importantInfoLong)
            @else
            <div class="descr">
                {{ $importantInfoLong }}
            </div>
            @endisset
        </div>
        @empty($importantInfoLong)
        @else
        <a href="javascript:void(0)" class="read-more">READ MORE</a>
        @endisset
    </div>
</section>

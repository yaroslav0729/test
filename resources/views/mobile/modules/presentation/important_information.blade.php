@php

    $importantInfoTitle = "";
    $importantInfo = "";
    $importantInfoLong = "";
    $bgClassImportant = "";

    if (isset($parameters['important_title'])) {
        $importantInfoTitle = $parameters['important_title'];
    }

    if (isset($parameters['important_text'])) {
        $importantInfo = $parameters['important_text'];
    }

    if (isset($parameters['important_text_long'])) {
        $importantInfoLong = $parameters['important_text_long'];
    }

    if (isset($parameters['bg_class_important'])) {
        $bgClassImportant = $parameters['bg_class_important'];
    }

@endphp


<section class="important-information @empty($bgClassImportant) bg-light @else {{ $bgClassImportant }} @endempty">
    <div class="wrap">
        <div class="title mb-2">
            <p class="font-size-16"><b>{{ $importantInfoTitle }}</b></p>
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

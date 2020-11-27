@php

    $needTitle = "";
    $needText = "";
    $needLinkText = "";
    $needLink = "";
    $needPhoto = "";


    if (isset($parameters['need_title'])) {
        $needTitle = $parameters['need_title'];
    }

    if (isset($parameters['need_text'])) {
        $needText = $parameters['need_text'];
    }

    if (isset($parameters['need_link_text'])) {
        $needLinkText = $parameters['need_link_text'];
    }

    if (isset($parameters['need_link'])) {
        $needLink = $parameters['need_link'];
    }

    if (isset($parameters['need_photo'])) {
        $needPhoto = $parameters['need_photo'];
    }

@endphp

<section class="mission-impossible">
    <div class="wrap">
        <div class="title">Islamic Help needs you</div>
    </div>
    <div class="wrap">
        <div class="body">
            <div class="row gutter-0">
                <div class="col-7" style="z-index: 2">
                    <div class="text bg-info">
                        <div class="tl">{{ $needTitle }}</div>
                        <p>{!! $needText !!}</p>
                    </div>
                    <div class="text-right">
                        <a href="{{ $needLink }}" class="btn btn-danger view-more">{{ $needLinkText }}</a>
                    </div>
                </div>
                <div class="col-5 img" style="background-image: url({{ $needPhoto }})">&nbsp;</div>
            </div>
        </div>
    </div>
</section>

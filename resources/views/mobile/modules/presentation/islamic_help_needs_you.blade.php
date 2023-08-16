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
    <div class="title">Mission Impossible</div>
    <div class="wrap">
        <div class="body">
            <div class="text bg-danger">
                <div class="tl">{{ $needTitle }}</div>
            </div>
            <div class="img" style="background-image: url({{ $needPhoto }})">&nbsp;</div>
            <div class="text-center bg-danger-light">
                <a href="{{ $needLink }}" class="btn btn-danger-light view-more">{{ $needLinkText }}</a>
            </div>
        </div>
    </div>
</section>

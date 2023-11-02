@php

    $projHeading = '';

    $projPar1 = '';
    $projPar2 = '';
    $projPar3 = '';

    $projVideo = '';
    $projVideoPreview = '';

    $projHeader1 = '';
    $projHeader2 = '';
    $projHeader3 = '';

    $widgetHtml = '';

    if (isset($parameters['proj_heading'])) {
        $projHeading = $parameters['proj_heading'];
    }

    if (isset($parameters['proj_par1'])) {
        $projPar1 = $parameters['proj_par1'];
    }

    if (isset($parameters['proj_par2'])) {
        $projPar2 = $parameters['proj_par2'];
    }

    if (isset($parameters['proj_par3'])) {
        $projPar3 = $parameters['proj_par3'];
    }

    if (isset($parameters['proj_hdr1'])) {
        $projHeader1 = $parameters['proj_hdr1'];
    }

    if (isset($parameters['proj_hdr2'])) {
        $projHeader2 = $parameters['proj_hdr2'];
    }

    if (isset($parameters['proj_hdr3'])) {
        $projHeader3 = $parameters['proj_hdr3'];
    }

    if (isset($parameters['proj_video'])) {
        $projVideo = $parameters['proj_video'];
    }

    if (isset($parameters['proj_video_preview'])) {
        $projVideoPreview = $parameters['proj_video_preview'];
    }

    if (isset($parameters['widget_html'])) {
        $widgetHtml = $parameters['widget_html'];
    }

    $videoRenderedBlock = \App\Models\Widget::replaceMonikers('{video-carousel|' . $projVideo . ',' . $projVideoPreview . '}');

    $isEmergency = \App\Models\Project::isEmergency($pageInstance);

    $col1Class = 'col-12 col-lg-6';
    $col2Class = 'col-12 col-lg-6';

@endphp

<div class="pt-4"></div>
<div class="pt-5"></div>

<section class="donate-today @if ($isEmergency) red-gradient @else blue-gradient @endif">
    <div class="wrap">
        <div class="title mb-5" project-title>
            <p class="font-size-40">
                @empty($projHeading)
                    <b>{{ $pageInstance->name }}</b>
                @else
                    <b>{{ $projHeading }}</b>
                @endempty

            </p>
            <i class="moon-icons-arrow-down"></i>
        </div>
        <div class="pt-5"></div>

        <div class="body">
            <div class="row gutter-0">
                <div class="{{ $col1Class }}">

                    @empty($donateVideo)
                        @empty($donateImg)
                            <div class="media donation" style="background-image: url(img/content/donate-today-1.jpg);">
                                <img src="" alt="" class="w-100">
                            @else
                                <div class="media" style="background-image: url({{ $donateImg }});">
                                @endempty
                            </div>
                            <div class="media appeal d-none"
                                style="background-image: url(img/content/values-action-4.jpg);"></div>
                        @else
                            <div class="media img-video videoWrapper" style="background: #555">
                                <div class="video-poster">
                                    <button class="video-poster__play video-poster__play"
                                        data-url="https://www.youtube.com/embed/{{ $donateVideo }}"><i
                                            class="ico-play"></i></button>
                                    <img class="video-poster__img"
                                        src="https://img.youtube.com/vi/{{ $donateVideo }}/maxresdefault.jpg">
                                </div>
                                <iframe width="1280" height="720"
                                    src="https://www.youtube.com/embed/{{ $donateVideo }}" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                            </div>
                        @endempty
                    </div>
                    <div class="{{ $col2Class }}">
                        {{--            if 1-2 tabs - col-5 --}}
                        <div class="donate-today-sheet">
                            {!! $widgetHtml !!}
                        </div>
                    </div>
                </div>

            </div>
</section>

<div class="pt-5"></div>
<div class="pt-5"></div>

<section class="blog-article-body">
    <div class="wrap">
        <div class="body">
            @if ($pageInstance->slug === 'live')
                <div class="d-flex justify-content-start mb-3">
                    <a href="{{ url('/zakat-cash') }}" class="text-underline text-uppercase text-dark cash-link">Give
                        Zakat Cash Here</a>
                </div>
            @endif
            <h2>{{ $projHeader1 }}</h2>
            <p>{{ $projPar1 }}</p>

            <h2>{{ $projHeader2 }}</h2>
            <p @if (!empty($projVideo)) class="m-video" @endif>
                {{ $projPar2 }}</p>

            @if (!empty($projVideo))
                {!! $videoRenderedBlock !!}
            @endif

            <h2>{{ $projHeader3 }}</h2>
            <p class="m-last">{{ $projPar3 }}</p>
        </div>
    </div>
    @include('modules.presentation.share_this')
</section>

<div class="pt-5"></div>

<style>
    .blog-article-body h2 {
        font-size: 28px;
    }
</style>

@include('modules.presentation.what_happens_so_far')

@include('modules.presentation.important_information')

<div class="pt-4"></div>

@include('modules.presentation.related_topics_project')

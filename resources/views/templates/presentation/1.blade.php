@php

$minRead = '';
$headerText = '';
$writtenBy = '';
$headerVideo = '';
$headerVideoPreview = '';
$articleHtml = '';

if (isset($parameters['min_read'])) {
    $minRead = $parameters['min_read'];
}

if (isset($parameters['hdr_text'])) {
    $headerText = $parameters['hdr_text'];
}

if (isset($parameters['written_by'])) {
    $writtenBy = $parameters['written_by'];
}

if (isset($parameters['hdr_video'])) {
    $headerVideo = $parameters['hdr_video'];
}

if (isset($parameters['hdr_video_preview'])) {
    $headerVideoPreview = $parameters['hdr_video_preview'];
}

if (isset($parameters['article_html'])) {
    $articleHtml = $parameters['article_html'];
}

@endphp

<section class="blog-article-head">
    <div class="wrap">
        <div class="mb-4">
            @include('templates.presentation.parts.back_btn')
        </div>

        <div class="row">
            <div class="col-12 col-lg-5 article-text">
                <h1>{{ $pageInstance->name }}</h1>
                <div class="date">
                    <span>{{ $minRead }}</span>
                    <i></i>{{ date('d F Y', strtotime($pageInstance->published_at)) }}
                </div>
                <p>
                    {{ $headerText }}
                </p>
                <div class="author mb-4 mb-lg-0">
                    <div class="img" style="background-image: url(img/logo.png)"></div>
                    <span>written by <span>|</span> Islamic Help</span>
                </div>
            </div>
            <div class="col-12 col-lg-7">
                <div class="img-video videoWrapper" style="@if (!empty($headerVideo)) background: #555 @else background-image: url('{{ $pageInstance->preview_img }}'); background-size: 100% 100%; background-repeat: no-repeat; @endif">
                    @if (!empty($headerVideo))
                        @empty($headerVideo)
                            <i class="fas fa-play-circle"></i>
                        @endempty
                        <div class="video-poster">
                            <button class="video-poster__play video-poster__play"
                                data-url="https://www.youtube.com/embed/{{ $headerVideo }}"><i
                                    class="ico-play"></i></button>
                            <img class="video-poster__img" src="@if (!$headerVideoPreview) https://img.youtube.com/vi/{{ $headerVideo }}/0.jpg @else {{ $headerVideoPreview }} @endif">
                        </div>
                        <iframe width="1280" height="720" src="https://www.youtube.com/embed/{{ $headerVideo }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    @endif
                </div>
            </div>
        </div>

    </div>
</section>

<section class="blog-article-body">
    <div class="wrap">
        <div class="body">
            {!! $articleHtml !!}
        </div>
    </div>
    @include('modules.presentation.share_this')
</section>

<div class="pt-5"></div>

{{-- @include('modules.presentation.mission_possible')

<div class="pt-5"></div> --}}


<section class="blog-article-body">
    <div class="wrap">
        <div class="pt-5"></div>
        <div class="row align-items-center">
            <div class="col-6 col-lg-4">
                <div class="author">
                    <div class="img" style="background-image: url(img/logo.png)"></div>
                    <span>written by <span>|</span>Islamic Help</span>
                </div>
            </div>
            <div class="col-1"></div>
            <div class="col-5 col-lg-7">
                <div class="black-line"></div>
            </div>
        </div>
        <div class="pt-5 pb-2"></div>
    </div>
</section>

@include('modules.presentation.related_topics_project', [
'parameters' => $parameters,
'svgWave' => true
])


@include('modules.presentation.join_the_cause_subscribe')


@include('modules.presentation.image_lightbox')

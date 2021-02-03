@php

    $minRead = "";
    $headerText="";
    $writtenBy="";
    $headerVideo = "";
    $articleHtml = "";
    $previewPageTitle = "";
    $previewPageText1 = "";
    $previewPageText2 = "";
    $previewPageLink = "";
    $previewPageImage = "";

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

    if (isset($parameters['article_html'])) {
        $articleHtml = $parameters['article_html'];
    }

    if (isset($parameters['preview_page_title'])) {
        $previewPageTitle = $parameters['preview_page_title'];
    }

    if (isset($parameters['preview_page_text1'])) {
        $previewPageText1 = $parameters['preview_page_text1'];
    }

    if (isset($parameters['preview_page_text2'])) {
        $previewPageText2 = $parameters['preview_page_text2'];
    }

    if (isset($parameters['preview_page_link'])) {
        $previewPageLink = $parameters['preview_page_link'];
    }

    if (isset($parameters['preview_page_image'])) {
        $previewPageImage = $parameters['preview_page_image'];
    }

@endphp

<section class="blog-article-head">
    <div class="wrap">
        <div class="mb-4">
            @include('templates.presentation.parts.back_btn')
        </div>

        <div class="article-text">
            <h1>{{ $pageInstance->name }}</h1>

            <div class="img-video videoWrapper" style="background: #555">
                @empty($headerVideo)
                    <i class="fas fa-play-circle"></i>
                @endempty
                <iframe width="1280" height="720" src="https://www.youtube.com/embed/{{ $headerVideo }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>

            <div class="date">
                <span>{{ $minRead }}</span>
                <i></i>{{ date('d F Y', strtotime($pageInstance->published_at)) }}
            </div>
            <p>{{ $headerText }}</p>
            <div class="author">
                <div class="img" style="background-image: url(img/content/Avatar1.jpg)"></div>
                <span>written by <span>|</span> {{ $writtenBy }}</span>
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

<section class="mission-impossible">
    <div class="title">{{ $previewPageTitle }}</div>
    <div class="wrap">
    <div class="body">
        <div class="text bg-danger">
            <div class="tl">{{ $previewPageText1 }}</div>
        </div>
        <div class="img" style="background-image: url({{ $previewPageImage }})">&nbsp;</div>
        <div class="text-center bg-danger-light">
            <a href="{{ $previewPageLink }}" class="btn btn-danger-light view-more">Learn more</a>
        </div>
    </div>
    </div>
</section>

<div class="pt-5"></div>

@include('modules.presentation.related_page_expanded')

@include('modules.presentation.join_the_cause_subscribe')

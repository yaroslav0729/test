@php

$mainHtml = '';

if (isset($parameters['main_html'])) {
    $mainHtml = $parameters['main_html'];
}

$parameters['template'] = \App\Models\Template::COMMON_CONTENT_PAGE;

@endphp

<section class="back">
    <div class="wrap">
        @include('templates.presentation.parts.back_btn')
    </div>
</section>

<section class="general-content-head bg-light">
    <div class="wrap">
        <div class="black-line"></div>
        <div class="image-box">
            <img src="{{ $pageInstance->preview_img }}" alt="" class="image-box-inside">
        </div>
        <div class="black-line"></div>
        <div class="page-title">
            <h1>{!! $pageInstance->name !!}</h1>
            @if (!strpos(url()->full(), 'khalifahs-of-earth'))
                <div class="date">
                    <i></i>{{ Illuminate\Support\Carbon::parse($pageInstance->published_at)->format('jS F Y') }}
                </div>
            @endif
        </div>
        <div class="black-line black-line--thin"></div>
    </div>
</section>

<section class="blog-article-body">
    <div class="body">
        <div class="cite">
            {!! $pageInstance->preview_text !!}
        </div>
        <div class="pt-4"></div>

        {!! $mainHtml !!}
    </div>
    <div class="author">
        <div class="img" style="background-image: url(/img/logo.png)"></div>
        <span>written by <span class="divider">|</span> islamic help</span>
    </div>
</section>

<div class="pt-5"></div>

@include('modules.presentation.related_topics_project', [
'parameters' => $parameters,
'svgWave' => true,
])

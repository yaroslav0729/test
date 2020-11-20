@php

    $mainHtml = "";
    $importantInfoTitle = "";
    $importantInfo = "";

    if (isset($parameters['main_html'])) {
        $mainHtml = $parameters['main_html'];    
    }

    if (isset($parameters['important_title'])) {
        $importantInfoTitle = $parameters['important_title'];    
    }

    if (isset($parameters['important_text'])) {
        $importantInfo = $parameters['important_text'];    
    }

@endphp

<div class="pt-4"></div>
<div class="pt-5"></div>

<section class="donate-today blue-gradient">
    <div class="wrap">
        <div class="title mb-5">
            <p class="font-size-40"><b>{{ $pageInstance->name }}</b></p>
            <i class="far fa-arrow-down"></i>
        </div>
        <div class="pt-5"></div>

        @include('modules.presentation.projects_donate', ['parameters' => $parameters])

    </div>
</section>

<div class="pt-5"></div>
<div class="pt-5"></div>

<section class="blog-article-body">
    <div class="wrap">
        <div class="body">
            {!! $mainHtml !!}
        </div>
    </div>
</section>

<div class="pt-5"></div>

@include('modules.presentation.share_this')

@include('modules.presentation.what_happens_so_far')

@include('modules.presentation.we_still_need_support')

<section class="join-cause">
    <div class="wrap">
        <div class="title mb-5">
            <p class="font-size-30"><b>{{ $importantInfoTitle }}</b></p>
        </div>
        <p class="font-size-20">
            {{ $importantInfo }}
        </p>
    </div>
</section>

@include('modules.presentation.related_pages', [
    'parameters' => $parameters
])

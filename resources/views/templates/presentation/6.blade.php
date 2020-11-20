@php

    $mainHtml = "";

    if (isset($parameters['main_html'])) {
        $mainHtml = $parameters['main_html'];    
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

@include('modules.presentation.important_information')

@include('modules.presentation.related_pages')

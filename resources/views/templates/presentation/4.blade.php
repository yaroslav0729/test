@php

    $mainHtml = "";

    if (isset($parameters['main_html'])) {
        $mainHtml = $parameters['main_html'];    
    }

@endphp

@if(!empty($pageInstance->preview_img))
    @include('modules.presentation.header_img')
@endif

<section class="blog-article-body">
    <div class="wrap">
        <div class="body">
            <h2>{!! $pageInstance->name !!}</h2>
            <div class="date pt-4 pb-4">
                <i class="fas fa-calendar-alt"></i>
                <span>{{ date('d F Y', strtotime($pageInstance->published_at)) }}</span>
            </div>
            {!! $mainHtml !!}

        </div>
    </div>
    @include('modules.presentation.share_this')
</section>

<div class="pt-5"></div>

<section class="blog-article-body">
    <div class="wrap">
            <div class="pt-5"></div>
            <div class="row align-items-center">
                <div class="col-4">
                    <div class="author">
                        <div class="img" style="background-image: url(img/content/Avatar1.jpg)"></div>
                        <span>written by <span>|</span> jamaila hamid</span>
                    </div>
                </div>
                <div class="col-1"></div>
                <div class="col-7">
                    <div class="black-line"></div>
                </div>
            </div>
            <div class="pt-5 pb-2"></div>
        </div>

</section>

<section>
    @include('modules.presentation.related_pages', [
        'parameters' => $parameters
    ])
</section>


@include('modules.presentation.join_the_cause_subscribe')


@php

    $mainHtml = "";

    if (isset($parameters['main_html'])) {
        $mainHtml = $parameters['main_html'];
    }

    $parameters['template'] = \App\Models\Template::COMMON_CONTENT_PAGE;

@endphp
<section class="back">
    <div class="wrap">
        <div class="mb-5 mt-5">
            @include('templates.presentation.parts.back_btn')
        </div>
    </div>
</section>

@if(!empty($pageInstance->preview_img))
    @include('modules.presentation.header_img')
@endif

<section class="blog-article-body">
    <div class="wrap">
        <div class="body">
            <div class="cite">
                {!! $pageInstance->preview_text !!}
            </div>
            <h2 class="mt-md-5">{!! $pageInstance->name !!}</h2>
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
                <div class="col-6 col-lg-4">
                    <div class="author">
                        <div class="img" style="background-image: url(/storage/icons/Avatar1.jpg)"></div>
                        <span>written by <span>|</span> jamaila hamid</span>
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
    'parameters' => $parameters
])

@include('modules.presentation.join_the_cause_subscribe')


@php

    $mainHtml = "";

    if (isset($parameters['main_html'])) {
        $mainHtml = $parameters['main_html'];    
    }

@endphp

<div class="pt-4"></div>
<section class="donate-today">
    <div class="wrap">
        <div class="title text-left pr-5">
            <p><b>{{ $pageInstance->name }}</b></p>
            <i class="far fa-arrow-down"></i>
        </div>

        @include('modules.presentation.projects_donate')
        
    </div>
</section>


<section class="blog-article-body">
    <div class="wrap">
        <div class="body">
            {!! $mainHtml !!}
        </div>
    </div>
</section>

<div class="pt-5"></div>

@include('modules.presentation.what_happens_so_far')

@include('modules.presentation.we_still_need_support')

@include('modules.presentation.important_information')

@include('modules.presentation.related_pages')

@include('modules.presentation.join_the_cause_subscribe')

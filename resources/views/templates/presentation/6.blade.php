@php

    $mainHtml = "";

    if (isset($parameters['main_html'])) {
        $mainHtml = $parameters['main_html'];    
    }

    $projHeading = "";

    if (isset($parameters['proj_heading'])) {
        $projHeading = $parameters['proj_heading'];    
    }

    $isEmergency = \App\Models\Project::isEmergency($pageInstance);

@endphp

<div class="pt-4"></div>
<div class="pt-5"></div>

<section class="donate-today @if($isEmergency) red-gradient @else blue-gradient @endif">
    <div class="wrap">
        <div class="title mb-5" project-title>
            <p class="font-size-40">
                @empty($projHeading)
                <b>{{ $pageInstance->name }}</b>
                @else
                <b>{{ $projHeading}}</b>
                @endempty
                
            </p>
            <i class="moon-icons-arrow-down"></i>
        </div>
        <div class="pt-5"></div>

        @include('modules.presentation.donate_module', [
            'colorInfo' => true
        ])

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

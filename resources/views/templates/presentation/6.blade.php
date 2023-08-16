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

$videoRenderedBlock = \App\Models\Widget::replaceMonikers('{video-carousel|' . $projVideo . ',' . $projVideoPreview . '}');

$isEmergency = \App\Models\Project::isEmergency($pageInstance);

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
            @if($pageInstance->slug === 'live')
                <div class="d-flex justify-content-start mb-3">
                    <a href="{{ url('/zakat-cash') }}" class="text-underline text-uppercase text-dark cash-link">Give Zakat Cash Here</a>
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

@include('modules.presentation.we_still_need_support')

@include('modules.presentation.important_information')

<div class="pt-4"></div>

@include('modules.presentation.related_topics_project')

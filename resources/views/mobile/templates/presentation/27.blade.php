@php

$projHeading = '';
$projSubheading = '';
$projImage = '';
$projDescription = '';

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

if (isset($parameters['proj_subheading'])) {
    $projSubheading = $parameters['proj_subheading'];
}

if (isset($parameters['proj_image'])) {
    $projImage = $parameters['proj_image'];
}

if (isset($parameters['proj_description'])) {
    $projDescription = $parameters['proj_description'];
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

@endphp

<section class="donate-today" style="background-color: #291f4d;">
    <div class="wrap">
        <div style="border-bottom: 5px solid #fff; padding: 0 10px; position: relative;">
            <div class="media" style="width: 100%; margin: 0;">
                <img src="{{ $projImage }}" style="width: 100%; height: 100%; object-fit: cover; max-height: 400px;">
            </div>
            <div class="title" style="display: flex; align-items: center; justify-content: center; width: 100%;" project-title>
                <div style="display: flex; flex-direction: column;">
                    <div style="color: #fac16a; font-size: 2rem; text-wrap: nowrap;">
                        @empty($projHeading)
                        <b>{{ $pageInstance->name }}</b>
                        @else
                        <b>{{ $projHeading }}</b>
                        @endempty
                    </div>
                    <div style="text-align: left; white-space: pre-wrap; color: #fff; font-size: 1.5rem; font-weight: 900;">{{ $projSubheading }}</div>
                </div>
            </div>
        </div>
        <div style="">
            <div class="font-size-15" style="text-align: left; white-space: pre-wrap; color: #fff; padding: 10px 0;">{{ $projDescription }}</div>
            <div style="color: #fff; font-size: 20px; font-weight: bold;">SELECT WHERE YOU’D LIKE TO GIVE YOUR QURBANI:</div>
            @include('pages.enhanced-qurbani')
        </div>
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
</section>

<div class="pt-5"></div>

<style>
    .blog-article-body h2 {
        font-size: 28px;
    }

</style>

@include('modules.presentation.what_happens_so_far')

@include('modules.presentation.donate_today')

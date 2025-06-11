@php

$projHeading = '';

$projPar1 = '';
$projPar2 = '';
$projPar3 = '';
$projPar4 = '';

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

if (isset($parameters['proj_par4'])) {
    $projPar4 = $parameters['proj_par4'];
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

if (isset($parameters['proj_hdr4'])) {
    $projHeader4 = $parameters['proj_hdr4'];
}

if (isset($parameters['proj_video'])) {
    $projVideo = $parameters['proj_video'];
}

if (isset($parameters['proj_video_preview'])) {
    $projVideoPreview = $parameters['proj_video_preview'];
}

$videoRenderedBlock = \App\Models\Widget::replaceMonikers('{video-carousel|' . $projVideo . ',' . $projVideoPreview . '}');

$isEmergency = \App\Models\Project::isEmergency($pageInstance ?? null);

$requestPath = request()->path();
$pageData = [];
if ($requestPath === 'winter-2024') $pageData['isWinter2024Page'] = true;
if ($requestPath === 'orphancare') $pageData['isOrphanCarePage'] = true;
@endphp

<div class="pt-4"></div>
<section class="donate-today">
    <div class="wrap">
        <div class="title text-left pr-5">
            <p><b>{{ $pageInstance->name }}</b></p>
            <i class="moon-icons-arrow-down"></i>
        </div>

        @include('modules.presentation.donate_module', [
             'colorInfo' => true, $pageData])

    </div>
</section>


<section class="blog-article-body">
    <div class="wrap">
        <div class="body">
            @if($pageInstance->slug === 'live')
                <div class="d-flex justify-content-start mb-3">
                    <a href="{{ url('/zakat-cash') }}" class="text-underline text-uppercase text-dark cash-link">Give Zakat Cash Here</a>
                </div>
            @endif
            <h2>{{ $projHeader1 }}</h2>
            <p>{!! nl2br(e($projPar1)) !!}</p>

            <h2>{{ $projHeader2 }}</h2>
            <p>{!! nl2br(e($projPar2)) !!}</p>

            @if (!empty($projVideo))
                {!! $videoRenderedBlock !!}
            @endif

            <h2>{{ $projHeader3 }}</h2>
            <p>{!! nl2br(e($projPar3)) !!}</p>

            <h2>{{ $projHeader4 }}</h2>
            <p>{!! nl2br(e($projPar4)) !!}</p>
        </div>
    </div>
</section>

<div class="p-divide-30"></div>

@include('modules.presentation.what_happens_so_far')

@include('modules.presentation.we_still_need_support')

@include('modules.presentation.important_information')

@include('modules.presentation.related_topics_project')

@include('modules.presentation.join_the_cause_subscribe2')

@php

    $ourWorkTitle = "";
    $ourWorkLink = "";

    $longtermTitle = "";
    $longtermText = "";
    $longtermVideo = "";

    $emergencyTitle = "";
    $emergencyText = "";
    $emergencyVideo = "";

    $volunteeringTitle = "";
    $volunteeringText = "";
    $volunteeringVideo = "";

    $sadiqahTitle = "";
    $sadiqahText = "";
    $sadiqahVideo = "";


    if (isset($parameters['our_work_block_title'])) {
        $ourWorkTitle = $parameters['our_work_block_title'];
    }

    if (isset($parameters['our_work_block_link'])) {
        $ourWorkLink = $parameters['our_work_block_link'];
    }

    if (isset($parameters['our_work_longterm_title'])) {
        $longtermTitle = $parameters['our_work_longterm_title'];
    }

    if (isset($parameters['our_work_longterm_text'])) {
        $longtermText = $parameters['our_work_longterm_text'];
    }

    if (isset($parameters['our_work_longterm_video'])) {
        $longtermVideo = $parameters['our_work_longterm_video'];
    }

    if (isset($parameters['our_work_emergency_title'])) {
        $emergencyTitle = $parameters['our_work_emergency_title'];
    }

    if (isset($parameters['our_work_emergency_text'])) {
        $emergencyText = $parameters['our_work_emergency_text'];
    }

    if (isset($parameters['our_work_emergency_video'])) {
        $emergencyVideo = $parameters['our_work_emergency_video'];
    }

    if (isset($parameters['our_work_volunteering_title'])) {
        $volunteeringTitle = $parameters['our_work_volunteering_title'];
    }

    if (isset($parameters['our_work_volunteering_text'])) {
        $volunteeringText = $parameters['our_work_volunteering_text'];
    }

    if (isset($parameters['our_work_volunteering_video'])) {
        $volunteeringVideo = $parameters['our_work_volunteering_video'];
    }

    if (isset($parameters['our_work_sadiqah_title'])) {
        $sadiqahTitle = $parameters['our_work_sadiqah_title'];
    }

    if (isset($parameters['our_work_sadiqah_text'])) {
        $sadiqahText = $parameters['our_work_sadiqah_text'];
    }

    if (isset($parameters['our_work_sadiqah_video'])) {
        $sadiqahVideo = $parameters['our_work_sadiqah_video'];
    }

@endphp

<section class="our-work">
    <div class="wrap">
        <div class="mb-4">
            <a href="{{ $ourWorkLink }}"
               class="text-underline text-dark view-more text-uppercase"><b>{{ $ourWorkTitle }}</b></a>
        </div>
        <div class="row">
            <div class="col-6 col-lg-3">
                <a href="#" class="our-work-main" id="our-work-main-1">
                    <span style="background-image: url(img/ico-leaf.svg)"></span>
                    <p>{{ $longtermTitle }}</p>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="#" class="our-work-main" id="our-work-main-2">
                    <span style="background-image: url(img/ico-alert.svg)"></span>
                    <p>{{ $emergencyTitle }}</p>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="#" class="our-work-main" id="our-work-main-3">
                    <span style="background-image: url(img/ico-motivation.svg)"></span>
                    <p>{{ $volunteeringTitle }}</p>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="#" class="our-work-main" id="our-work-main-4">
                    <span style="background-image: url(img/ico-Saadiqah.svg)"></span>
                    <p>{{ $sadiqahTitle }}</p>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="our-work-term d-none">
    <div class="wrap">
        <div class="mb-4">
            <a href="{{ $ourWorkLink }}" class="text-underline text-dark view-more"><b class="text-uppercase">{{ $ourWorkTitle }}</b></a>
        </div>

        <div class="body">
            <div class="bg bg-1 our-work-bg" id="our-work-term-bg-1"><span class="bg-info"></span><span class="bg-info"></span></div>
            <div class="bg bg-2 d-none our-work-bg" id="our-work-term-bg-2"><span class="bg-danger"></span><span
                    class="bg-danger"></span></div>
            <div class="bg bg-3 d-none our-work-bg" id="our-work-term-bg-3"><span class="bg-dark"></span><span class="bg-dark"></span>
            </div>
            <div class="bg bg-4 d-none our-work-bg" id="our-work-term-bg-4"><span class="bg-warning"></span><span
                    class="bg-warning"></span></div>
            <div class="row">
                <div class="col-6">
                    <div class="box our-work-content" style="background-image: url(img/ico-leaf.svg)" id="our-work-term-1">
                        <h2>{{ $longtermTitle }}</h2>
                        <p>{!! $longtermText !!}</p>
                    </div>
                    <div class="box d-none our-work-content" style="background-image: url(img/ico-alert.svg)" id="our-work-term-2">
                        <h2>{{ $emergencyTitle }}</h2>
                        <p>{!! $emergencyText !!}</p>
                    </div>
                    <div class="box d-none our-work-content" style="background-image: url(img/ico-motivation.svg)" id="our-work-term-3">
                        <h2>{{ $volunteeringTitle }}</h2>
                        <p>{!! $volunteeringText !!}</p>
                    </div>
                    <div class="box d-none our-work-content" style="background-image: url(img/ico-Saadiqah.svg)" id="our-work-term-4">
                        <h2>{{ $sadiqahTitle }}</h2>
                        <p>{!! $sadiqahText !!}</p>
                    </div>

                </div>
                <div class="col-6">
                    <div class="img-video videoWrapper our-work-video" id="our-work-video-term-1">
                        <iframe width="1280" height="720" src="https://www.youtube.com/embed/{{ $longtermVideo }}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        <div class="caption bg-info">IH sponsorships <b>orphans</b></div>
                    </div>
                    <div class="img-video d-none videoWrapper our-work-video" id="our-work-video-term-2">
                        <iframe width="1280" height="720" src="https://www.youtube.com/embed/{{ $emergencyVideo }}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        <div class="caption bg-danger">IH sponsorships <b>orphans</b></div>
                    </div>
                    <div class="img-video d-none videoWrapper our-work-video" id="our-work-video-term-3">
                        <iframe width="1280" height="720" src="https://www.youtube.com/embed/{{ $volunteeringVideo }}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        <div class="caption bg-primary">IH sponsorships <b>orphans</b></div>
                    </div>
                    <div class="img-video d-none videoWrapper our-work-video" id="our-work-video-term-4">
                        <iframe width="1280" height="720" src="https://www.youtube.com/embed/{{ $sadiqahVideo }}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        <div class="caption bg-warning text-dark">Seasonal <b>campaign</b></div>
                    </div>


                    <div class="row nav gutter-10 actions">
                        <div class="col-4 d-none our-work-nav">
                            <a href="#" data-target="1"><span
                                    style="background-image: url(img/ico-leaf.svg)"></span></a>
                        </div>
                        <div class="col-4 our-work-nav">
                            <a href="#" data-target="2"><span
                                    style="background-image: url(img/ico-alert.svg)"></span></a>
                        </div>
                        <div class="col-4 our-work-nav">
                            <a href="#" data-target="3"><span
                                    style="background-image: url(img/ico-motivation.svg)"></span></a>
                        </div>
                        <div class="col-4 our-work-nav">
                            <a href="#" data-target="4"><span
                                    style="background-image: url(img/ico-Saadiqah.svg)"></span></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

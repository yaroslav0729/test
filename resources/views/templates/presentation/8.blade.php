@php

    $bgImage = "";
    $ourMissionTitle = "";
    $ourValuesDescription = "";
    $ourValuesVideo = "";
    $mapImage = "";
    $mapAlternativeImage = "";
    $hdrColorType = "";

    $storyActive = $parameters['story_active'] ?? [];

    for ($i=1; $i<=4; $i++) {
        $actionActive[$i] = "";
        $actionName[$i] = "";
        $actionPhoto[$i] = "";
        $actionSlogan[$i] = "";
        $actionTitle[$i] = "";
        $actionDescription[$i] = "";
        $actionLearnMoreLink[$i] = "";
    }

    $colorNameClass = [
        1 => 'bg-primary-light',
        2 => 'bg-warning',
        3 => 'bg-danger',
        4 => 'bg-info' ];

    for ($i=1; $i<=3; $i++){
        ${'storyPhoto' . $i} = "";
        ${'storyYear' . $i} = "";
        ${'storyText' . $i} = "";
    }

    for ($i=1; $i<=2; $i++){
        ${'lifeChangingPhoto' . $i} = "";
        ${'lifeChangingPhrase' . $i} = "";
    }

    $lifeChangingBlockTitle = "";
    $lifeChangingBlockText = "";
    $lifeChangingBlockTextMobile = "";

    if (isset($parameters['hdr_color_type'])) {
        $hdrColorType = $parameters['hdr_color_type'];
    }

    if (isset($parameters['background_image'])) {
        $bgImage = $parameters['background_image'];
    }

    if (isset($parameters['our_mission_title'])) {
        $ourMissionTitle = $parameters['our_mission_title'];
    }

    if (isset($parameters['our_values_description'])) {
        $ourValuesDescription = $parameters['our_values_description'];
    }

    if (isset($parameters['our_values_video'])) {
        $ourValuesVideo = $parameters['our_values_video'];
    }

    if (isset($parameters['map_image'])) {
        $mapImage = $parameters['map_image'];
    }

    if (isset($parameters['map_alt_image'])) {
        $mapAlternativeImage = $parameters['map_alt_image'];
    }

/*    $actionActive = $parameters['action_active'] ?? [];*/

    for ($i=1; $i<=4; $i++){
        if (isset($parameters['action_active_' . $i])) {
            $actionActive[$i] = $parameters['action_active_' . $i];
        }
        if (isset($parameters['action_name_' . $i])) {
            $actionName[$i] = $parameters['action_name_' . $i];
        }
        if (isset($parameters['action_photo_' .$i])) {
            $actionPhoto[$i] = $parameters['action_photo_' . $i];
        }
        if (isset($parameters['action_slogan_' .$i])) {
            $actionSlogan[$i] = $parameters['action_slogan_' . $i];
        }
        if (isset($parameters['action_title_' .$i])) {
            $actionTitle[$i] = $parameters['action_title_' . $i];
        }
        if (isset($parameters['action_description_' .$i])) {
            $actionDescription[$i] = $parameters['action_description_' . $i];
        }
        if (isset($parameters['action_learn_more_link_' .$i])) {
            $actionLearnMoreLink[$i] = $parameters['action_learn_more_link_' . $i];
        }
    }

    for ($i=1; $i<=3; $i++){
        if (isset($parameters["story_year_{$i}"])) {
            ${'storyYear' . $i} = $parameters["story_year_{$i}"];
        }
        if (isset($parameters["story_photo_{$i}"])) {
            ${'storyPhoto' . $i} = $parameters["story_photo_{$i}"];
        }
        if (isset($parameters["story_text_{$i}"])) {
            ${'storyText' . $i} = $parameters["story_text_{$i}"];
        }
    }

    for ($i=1; $i<=2; $i++){
        if (isset($parameters["changing_block_photo_{$i}"])) {
            ${'lifeChangingPhoto' . $i} = $parameters["changing_block_photo_{$i}"];
        }
        if (isset($parameters["changing_block_phrase_{$i}"])) {
            ${'lifeChangingPhrase' . $i} = $parameters["changing_block_phrase_{$i}"];
        }
    }

    $changingActive = $parameters['changing_active'] ?? [];

    if (isset($parameters['changing_block_title'])) {
        $lifeChangingBlockTitle = $parameters['changing_block_title'];
    }

    if (isset($parameters['changing_block_text'])) {
        $lifeChangingBlockText = $parameters['changing_block_text'];
    }

    if (isset($parameters['changing_block_text_mobile'])) {
        $lifeChangingBlockTextMobile = $parameters['changing_block_text_mobile'];
    }

$ourValuesActive = false;
$ourValuesActiveLink = false;

@endphp

<section class="who-we-are-head" style="background-image: url('{{ $bgImage }}');">
    <div>OUR MISSION</div>
    <h1>{!! $ourMissionTitle !!}</h1>
</section>

<section class="our-values mt-n5">
    <div class="box">
        <div class="row gutter-0 align-items-center">
            <div class="col-6">
                <div class="title">OUR VALUES</div>
                <p class="pr-5">{!! $ourValuesDescription !!}</p>
            </div>
            <div class="col-6">
                <div class="img-video play-tr videoWrapper" style="">
                    <iframe width="1280" height="720" src="https://www.youtube.com/embed/{{ $ourValuesVideo }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="gw-map-btn">
    <div style="background-image: url({{ $mapImage }})" alt-src="{{ $mapAlternativeImage }}">
        <a href="#" id="btn-view-global-work" class="btn btn-info">View Global Work</a>
    </div>
</section>

@empty(!$actionActive)
    <section class="mb-5">
        <p class="font-size-20 text-uppercase"><b>Our values in action</b></p>
        <div class="black-line"></div>
    </section>
    <section class="values-action">
        <div class="row gutter-0">
            <div class="col-9">
                <div class="tab-content" id="nav-tabContent">
                    @for ($i = 1; $i <= 4; $i++)
                        @if(in_array($i, $actionActive ))
                            <div class="tab-pane fade show @if($ourValuesActive === false)active @endif"
                                 id="nav-{{ $i }}"
                                 role="tabpanel">
                                <div class="row gutter-0">
                                    <div class="col-6 img"
                                         style="background-image: url('{{ $actionPhoto[$i] }}')"> &nbsp;
                                    </div>
                                    <div class="col-6 {{ $colorNameClass[$i] }} text">
                                        <div>
                                            <p class="text-1">{!! $actionSlogan[$i] !!}</p>
                                            <p class="text-2">{!! $actionTitle[$i] !!}</p>
                                            <p class="text-3">{!! $actionDescription[$i] !!}</p>
                                            <div><a href="{{ $actionLearnMoreLink[$i] }}"><b>LEARN MORE</b></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php ($ourValuesActive = true)
                        @endif
                    @endfor
                </div>
            </div>
            <div class="col-3 values-action-nav">
                <div class="nav flex-column nav-pills" id="nav-tab" role="tablist">
                    @for ($i = 1; $i <= 4; $i++)
                        @if(in_array($i, $actionActive ))
                            <a class="nav-link @if($ourValuesActiveLink === false)active @endif" data-toggle="tab"
                               href="#nav-{{ $i }}"
                               role="tab"
                               aria-selected="true">{{ $actionName[$i] }}</a>
                            @php ($ourValuesActiveLink = true)
                        @endif
                    @endfor
                </div>
            </div>
        </div>
    </section>
@endempty

@empty(!$storyActive)
    <section class="our-story-swiper" swiper-wrapper="our-story">
        <div class="wrap">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @for ($i = 1; $i <= 3; $i++)
                        @if(in_array($i, $storyActive ))
                            <div class="swiper-slide d-flex align-items-start">
                                <div class="img-box">
                                    <div class="bg-warning">
                                        <div class="img"
                                             style="background-image: url('{{ ${'storyPhoto' . $i} }}')"></div>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="row title">
                                        <div class="col-6"><span
                                                class="d-inline-block pl-5">{{ ${'storyYear' . $i} }}</span>
                                        </div>
                                        <div class="col-6 text-right"><span>OUR STORY</span></div>
                                    </div>
                                    <div class="black-line"></div>
                                    <p class="pl-5 pr-5">{!! ${'storyText' . $i} !!}</p>
                                </div>
                            </div>
                        @endif
                    @endfor
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <div class="swiper-button-next"><i class="moon-icons-arrow-right"></i></div>

        </div>
    </section>
@endempty

<section class="mb-5">
    <p class="font-size-45"><b>Life changing support.</b></p>
</section>

@empty(!$changingActive)
    <section class="promo-project-swiper" swiper-wrapper="our-support">
        <div class="wrap @if($hdrColorType === 'blue') bg-primary-light @else bg-danger-light @endif">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @for ($i = 1; $i <= 2; $i++)
                        @if(in_array($i, $changingActive ))
                            <div class="swiper-slide">
                                <div class="row gutter-0 align-content-center">
                                    <div class="col-6 img"
                                         style="background-image: url('{{ ${'lifeChangingPhoto' . $i} }}')">
                                        <a href="{{ \App\Models\Page::getSinglePageUrl(\App\Models\Template::PROJECTS_PAGE) }}"
                                           class="btn @if($hdrColorType === 'blue') btn-info @else btn-danger @endif">Donate
                                            to this project &nbsp;&nbsp;<i class="moon-icons-plus"></i></a>
                                    </div>
                                    <div class="col-6 text">
                                        <div>{{ ${'lifeChangingPhrase' . $i} }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endfor
                </div>
                <a href="#" class="next swiper-button-next"><i class="moon-icons-arrow-right"></i></a>
            </div>
        </div>
    </section>
@endempty

<section class="blog-article-body">
    <div class="wrap">
        <div class="body">
            <h2>{{ $lifeChangingBlockTitle }}</h2>
            {!! $lifeChangingBlockText !!}
        </div>
    </div>
</section>

<div class="pt-5 pb-5"></div>

@include('modules.presentation.related_page_expanded', [
            'parameters' => $parameters
        ])

@include('modules.presentation.join_the_cause_subscribe')

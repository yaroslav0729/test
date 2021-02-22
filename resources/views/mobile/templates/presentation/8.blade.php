@php

    $bgImage = "";
    $ourMissionTitle = "";
    $ourValuesDescription = "";
    $ourValuesInActionDescription = "";
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

    $colorNameClass = [
        1 => 'bg-primary-light',
        2 => 'bg-warning',
        3 => 'bg-danger',
        4 => 'bg-info' ];

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

    if (isset($parameters['our_values_action_description'])) {
        $ourValuesInActionDescription = $parameters['our_values_action_description'];
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

@endphp

<section class="who-we-are-head" style="background-image: url({{ $bgImage }});">
    <div>OUR MISSION</div>
    <h1>{!! $ourMissionTitle !!}</h1>
</section>

<section class="our-values">
    <div class="title">OUR VALUES</div>
    <p>{!! $ourValuesDescription !!}</p>
    <div class="pb-4"></div>
    <div class="img-video play-tr videoWrapper" style="">
        <iframe width="1280" height="720" src="https://www.youtube.com/embed/{{ $ourValuesVideo }}"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
    </div>
</section>
<section class="gw-map-btn">
    <div style="background-image: url(img/who-we-are-map-mobile.jpg)" alt-src="{{ $mapAlternativeImage }}">
        <a href="#" id="btn-view-global-work" class="btn btn-info">View Global Work</a>
    </div>
</section>

@empty(!$actionActive)
<section class="mb-5 values-action-title">
    <p class="font-size-16 text-uppercase"><b>Our values in action</b></p>
    <div class="black-line"></div>
    <p class="mt-4">{!! $ourValuesInActionDescription !!}</p>
</section>
<section class="values-action" swiper-wrapper="our-values" swiper-autoHeight="true">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @for ($i = 1; $i <= 4; $i++)
                @if(in_array($i, $actionActive ))
                <div class="swiper-slide {{ $colorNameClass[$i] }}">
                    <i class="moon-icons-arrow-right swiper-button-next"></i>
                    <div class="text">
                        <p class="text-1">{!! $actionSlogan[$i] !!}</p>
                        <p class="text-2">{!! $actionTitle[$i] !!}</p>
                        <p class="text-3">{!! $actionDescription[$i] !!}</p>
                    </div>
                    <div><a href="{{ $actionLearnMoreLink[$i] }}" class="btn btn-primary-dark br-0"><b>Learn more</b></a></div>
                    <div class="img" style="background-image: url({{ $actionPhoto[$i] }})">&nbsp;
                        <span class="place"><i class="fal fa-map-marker-alt"></i>{{ $actionName[$i] }}</span>
                    </div>
                </div>
                @endif
            @endfor
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>
@endempty

@empty(!$storyActive)
<section class="our-story-swiper" swiper-wrapper="our-story" >
    <div class="wrap">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @for ($i = 1; $i <= 3; $i++)
                <div class="swiper-slide">
                    <div class="box">
                        <div class="row title">
                            <div class="col-9"><span class="d-block">OUR STORY | {{ ${'storyYear' . $i} }}</span></div>
                        </div>
                        <div class="black-line"></div>
                        <p class="">{!! ${'storyText' . $i} !!}</p>
                    </div>
                    <div class="img-box">
                        <div class="bg-warning">
                            <div class="img" style="background-image: url({{ ${'storyPhoto' . $i} }})"></div>
                        </div>
                        <div class="swiper-button-next"><i class="moon-icons-arrow-right"></i></div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
        <div class="swiper-button-next"><i class="moon-icons-arrow-right"></i></div>
    </div>
</section>
@endempty

<section class="mb-5">
    <p class="font-size-25"><b>Life changing support.</b></p>
</section>

@empty(!$changingActive)
<section class="promo-project-swiper" swiper-wrapper="our-support" swiper-autoHeight="true">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @for ($i = 1; $i <= 2; $i++)
                <div class="swiper-slide">
                    <div class="img" style="background-image: url({{ ${'lifeChangingPhoto' . $i} }})">
                       {{-- <a href="#" class="prev swiper-button-prev"><i class="moon-icons-arrow-left"></i></a>--}}
                        <a href="#" class="next swiper-button-next"><i class="moon-icons-arrow-right"></i></a>
                    </div>
                    <div class="black-line"></div>
                    <div class="text @if($hdrColorType === 'blue') bg-primary-light @else bg-danger-light @endif">
                        {{ ${'lifeChangingPhrase' . $i} }}
                        <a href="#" class="btn @if($hdrColorType === 'blue') btn-info @else btn-danger @endif">Donate to this project &nbsp;&nbsp;<i class="moon-icons-plus"></i></a>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>
@endempty

<section class="blog-article-body">
    <div class="body">
        <h2>{{ $lifeChangingBlockTitle }}</h2>
        <p>{!! $lifeChangingBlockTextMobile !!}</p>
    </div>
</section>

<div class="pt-2 pb-2"></div>

@include('modules.presentation.related_topics_project')

@include('modules.presentation.join_the_cause_subscribe')

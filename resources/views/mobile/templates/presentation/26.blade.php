@php

$bgImage = '';
$ourMissionTitle = '';
$ourValuesDescription = '';
$ourValuesInActionTitle = '';
$ourValuesInActionDescription = '';
$ourValuesVideo = '';
$ourValuesVideoPreview = '';
$mapImage = '';
$mapAlternativeImage = '';
$hdrColorType = '';

$storyActive = $parameters['story_active'] ?? [];

for ($i = 1; $i <= 4; $i++) {
    $actionActive[$i] = '';
    $actionName[$i] = '';
    $actionPhoto[$i] = '';
    $actionSlogan[$i] = '';
    $actionTitle[$i] = '';
    $actionDescription[$i] = '';
    $actionLearnMoreLink[$i] = '';
}

for ($i = 1; $i <= 3; $i++) {
    ${'storyPhoto' . $i} = '';
    ${'storyYear' . $i} = '';
    ${'storyText' . $i} = '';
}

for ($i = 1; $i <= 2; $i++) {
    ${'lifeChangingPhoto' . $i} = '';
    ${'lifeChangingPhrase' . $i} = '';
}

$lifeChangingBlockTitle = '';
$lifeChangingBlockText = '';
$lifeChangingBlockTextMobile = '';

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

if (isset($parameters['our_values_video_preview'])) {
    $ourValuesVideoPreview = $parameters['our_values_video_preview'];
}

if (isset($parameters['map_image'])) {
    $mapImage = $parameters['map_image'];
}

if (isset($parameters['map_alt_image'])) {
    $mapAlternativeImage = $parameters['map_alt_image'];
}

$colorNameClass = [
    1 => 'bg-emergency',
    2 => 'bg-emergency',
    3 => 'bg-emergency',
    4 => 'bg-emergency',
];

for ($i = 1; $i <= 4; $i++) {
    if (isset($parameters['action_active_' . $i])) {
        $actionActive[$i] = $parameters['action_active_' . $i];
    }
    if (isset($parameters['action_name_' . $i])) {
        $actionName[$i] = $parameters['action_name_' . $i];
    }
    if (isset($parameters['action_photo_' . $i])) {
        $actionPhoto[$i] = $parameters['action_photo_' . $i];
    }
    if (isset($parameters['action_slogan_' . $i])) {
        $actionSlogan[$i] = $parameters['action_slogan_' . $i];
    }
    if (isset($parameters['action_title_' . $i])) {
        $actionTitle[$i] = $parameters['action_title_' . $i];
    }
    if (isset($parameters['action_description_' . $i])) {
        $actionDescription[$i] = $parameters['action_description_' . $i];
    }
    if (isset($parameters['action_learn_more_link_' . $i])) {
        $actionLearnMoreLink[$i] = $parameters['action_learn_more_link_' . $i];
    }
}

if (isset($parameters['our_values_action_title'])) {
    $ourValuesInActionTitle = $parameters['our_values_action_title'];
}

if (isset($parameters['our_values_action_description'])) {
    $ourValuesInActionDescription = $parameters['our_values_action_description'];
}

for ($i = 1; $i <= 3; $i++) {
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

for ($i = 1; $i <= 2; $i++) {
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

$showPriceHandlers = false;

if (isset($parameters['donation_module_enabled'])) {
    $showPriceHandlers = $parameters['donation_module_enabled'] === '1';
}

$hideMap = '';
if (isset($parameters['hide_map'])) {
    $hideMap = $parameters['hide_map'];
}
$shouldHideMap = $hideMap === '1';

$hideOurStory = '';
if (isset($parameters['hide_our_story'])) {
    $hideOurStory = $parameters['hide_our_story'];
}
$shouldHideOurStory = $hideOurStory === '1';

$showFAQs = '';
if (isset($parameters['show_faq'])) {
    $showFAQs = $parameters['show_faq'];
}
$shouldShowFaq = $showFAQs === '1';

$faqs = [];
for ($i = 0; $i < 7; $i++) {
    if (isset($parameters['faq_question_' . $i])) {
        $faqs[$i]['question'] = $parameters['faq_question_' . $i];
    }
    if (isset($parameters['faq_answer_' . $i])) {
        $faqs[$i]['answer'] = $parameters['faq_answer_' . $i];
    }
}
$isEmergency = true;

$projectImagesCarousel = [];
for($i = 0; $i < 10; $i++) {
    if (isset($parameters['project_images_carousel_' . $i])) {
        $projectImagesCarousel[] = $parameters['project_images_carousel_' . $i];
    }
}

$requestPath = request()->path();
$locationText = 'Gaza';
if(strpos($requestPath, 'lebanon') !== false) {
    $locationText = 'Lebanon';
}
@endphp

<style>
    .bg-emergency {
        background-color: #F4533C !important;
    }
    .save-lives-head {
        color: white;
    }
    .save-lives-title {
        font-family: 'Hard';
        font-size: 80px !important;
        /* color: #F97866; */
    }

    p {
        text-align: justify !important;
    }
</style>
<section class="who-we-are-head save-lives-head" style="background-color: #F4533C;">
    <h1 class="save-lives-title">Save Lives</h1>
    <h1>{!! $ourMissionTitle !!}</h1>
</section>

@if ($showPriceHandlers)
    <section class="who-we-are-donate">
    @include('modules.presentation.donate_module', [
        'colorInfo' => true,
        'priceHandlersOnly' => true
    ])

    </section>
@endif

<section class="our-values new-our-values">
    {{-- <div class="title">The Need for Surgeons in {{$locationText}}</div> --}}
    <div class="title">A Ceasefire Shattered</div>
    <p>{!! $ourValuesDescription !!}</p>
    <div class="pb-4"></div>
    <div class="img-video play-tr videoWrapper" style="">
        <div class="video-poster">
            <button class="video-poster__play video-poster__play"
                data-url="https://www.youtube.com/embed/{{ $ourValuesVideo }}"><i class="ico-play"></i></button>
            <img class="video-poster__img" src="@if (!$ourValuesVideoPreview) https://img.youtube.com/vi/{{ $ourValuesVideo }}/maxresdefault.jpg @else {{ $ourValuesVideoPreview }} @endif">
        </div>
        <iframe width="1280" height="720" src="https://www.youtube.com/embed/{{ $ourValuesVideo }}" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen></iframe>
    </div>
</section>

@if(!$shouldHideMap)
<section class="gw-map-btn" style="display: none;">
    <div style="background-image: url(img/who-we-are-map-mobile.jpg)" alt-src="{{ $mapAlternativeImage }}">
        <a href="#" id="btn-view-global-work" class="btn btn-info">View Global Work</a>
    </div>
</section>
@endif

@empty(!$actionActive)
    <section class="mb-5 @if($shouldHideMap) mt-5 @endif values-action-title">
        <p class="font-size-16 text-uppercase"><b>{{ $ourValuesInActionTitle ? $ourValuesInActionTitle : 'Our values in action' }}</b></p>
        <div class="black-line"></div>
        <p class="mt-4">{!! $ourValuesInActionDescription !!}</p>
    </section>
    <section class="values-action new-values-action" swiper-wrapper="our-values" swiper-autoHeight="true">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @for ($i = 1; $i <= 4; $i++)
                    @if (in_array($i, $actionActive)) <div class="swiper-slide
                    {{ $colorNameClass[$i] }}">
                    <i class="moon-icons-arrow-right swiper-button-next"></i>
                    <div class="text">
                    <p class="text-1">{!! $actionSlogan[$i] !!}</p>
                    <p class="text-2">{!! $actionTitle[$i] !!}</p>
                    <p class="text-3">{!! $actionDescription[$i] !!}</p>
                    </div>
                    <div><a href="{{ $actionLearnMoreLink[$i] }}" class="btn btn-primary-dark
                    br-0 donate-now-link"><b>Donate now</b></a></div>
                    <div class="img" style="background-image:
                    url({{ $actionPhoto[$i] }})">&nbsp;
                    <span class="place"><i class="fal
                    fa-map-marker-alt"></i>{{ $actionName[$i] }}</span>
                    </div>
                    </div> @endif
                @endfor
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
@endempty

@if(!$shouldHideOurStory)
@empty(!$storyActive)
    <section class="our-story-swiper" swiper-wrapper="our-story">
        <div class="wrap">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="swiper-slide">
                            <div class="box">
                                <div class="row title">
                                    <div class="col-9"><span class="d-block">OUR STORY | {{ ${'storyYear' . $i} }}</span>
                                    </div>
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
@endif

@if($shouldShowFaq)
    <section class="mb-5">
        <p class="font-size-45 text-uppercase"><b>FAQ</b></p>
        <div class="faq-block">
            @foreach($faqs as $index => $faqItem)
                <div class="faq-item">
                    <div class="faq-item__question">{{ $faqItem['question'] }} <i class="far fa-plus float-right mr-3"></i></div>
                    <div class="faq-item__answer">{{ $faqItem['answer'] }}</div>
                </div>
            @endforeach
        </div>
    </section>

    <script>
        $('.faq-item').on('click', function () {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(this).find('.faq-item__answer').hide();
                $(this).find('.far').removeClass('fa-minus');
                $(this).find('.far').addClass('fa-plus');
            } else {
                $(this).addClass('active');
                $(this).find('.faq-item__answer').show();
                $(this).find('.far').removeClass('fa-plus');
                $(this).find('.far').addClass('fa-minus');
            }
        })
    </script>
@endif

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
                            {{-- <a href="#" class="prev swiper-button-prev"><i class="moon-icons-arrow-left"></i></a> --}}
                            <a href="#" class="next swiper-button-next"><i class="moon-icons-arrow-right"></i></a>
                        </div>
                        <div class="black-line"></div>
                        <div class="text @if ($hdrColorType==='blue' ) bg-primary-light @else bg-danger-light @endif">
                            {{ ${'lifeChangingPhrase' . $i} }}
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
<script>
    $(document).on("click", ".donate-now-link", function(e) {
        e.preventDefault();
        let donateModulePosition = $(".donate-today-sheet").offset().top;
        $("html, body").animate({ scrollTop: donateModulePosition }, 1000);
    });
</script>

@if ($showPriceHandlers)
    @include('modules.presentation.we_still_need_support')
@endif

@if(count($projectImagesCarousel) > 0)
<style>
    .carousel-title {
        color: #101525;
        font-size: 25px;
        font-weight: 900;
        line-height: 1.3;
        margin-bottom: 42px;
        text-transform: uppercase;
    }
</style>
<style>
    .project-images-carousel .swiper-container {
        width: 100%;
        height: 100%;
        padding-bottom: 45px;
    }

    .project-images-carousel .swiper-slide {
        width: 100%;
        height: 100%;
        position: relative
    }

    .project-images-carousel .swiper-slide .img-container {
        position: relative;
        padding-top: 56.25%; /* 16:9 Aspect Ratio */
        overflow: hidden;
    }

    .project-images-carousel .swiper-slide .img-container img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .project-images-carousel .swiper-pagination {
        text-align: center;
        margin-top: 0;
        position: relative;
        bottom: -30px;
    }

    .project-images-carousel .swiper-pagination .swiper-pagination-bullet {
        background: #1b2030;
        border-radius: 0;
        height: 4px;
        width: 40px;
        min-width: 10px;
        margin-right: 10px;
        opacity: 1;
    }

    .project-images-carousel .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active {
        background-color: #F4533C;
    }
</style>
<section class="project-images-carousel" swiper-wrapper="project-image-carousel" swiper-autoHeight="true">
    <h2 class="carousel-title">
            Together, with Gaza
    </h2>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @foreach($projectImagesCarousel as $image)
                @if($image)
                    <div class="swiper-slide">
                        <div class="img-container">
                            <img src="{{ $image }}" alt="{{ $image }}" class="img" />
                        </div>
                    </div>
                @endif
            @endforeach

        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>
@endif

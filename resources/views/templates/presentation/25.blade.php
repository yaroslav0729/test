@php
$bgImage = '';
$ourMissionTitle = '';
$ourValuesInActionTitle = '';
$ourValuesDescription = '';
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

$colorNameClass = [
    1 => 'bg-emergency',
    2 => 'bg-emergency',
    3 => 'bg-emergency',
    4 => 'bg-emergency',
];

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

if (isset($parameters['our_values_action_title'])) {
    $ourValuesInActionTitle = $parameters['our_values_action_title'];
}

/*    $actionActive = $parameters['action_active'] ?? [];*/

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

$ourValuesActive = false;
$ourValuesActiveLink = false;
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
        font-size: 130px !important;
        color: #F97866;
    }

    p {
        text-align: justify !important;
    }
</style>

<section class="who-we-are-head" style="background-color: #232051;">
    <h1 class="save-lives-title">Deliver Hope</h1>
    <h1>{!! $ourMissionTitle !!}</h1>

    @if ($showPriceHandlers)
        @include('modules.presentation.donate_module', [
            'colorInfo' => true,
            'priceHandlersOnly' => true
        ])
    @endif
</section>

<section class="our-values mt-n5">
    <div class="box pt-4 pt-lg-0">
        <div class="row gutter-0">
            <div class="col-12 col-text">
                {{-- <div class="title">The Need for Surgeons in {{$locationText}}</div> --}}
                <div class="title">A Tentative Ceasefire</div>
                <p>{!! $ourValuesDescription !!}</p>
            </div>
            <div class="col-12 col-media">
                <div class="img-video play-tr videoWrapper" style="">
                    <div class="video-poster">
                        <button class="video-poster__play video-poster__play--medium"
                            data-url="https://www.youtube.com/embed/{{ $ourValuesVideo }}"><i
                                class="ico-play"></i></button>
                        <img class="video-poster__img" src="@if (!$ourValuesVideoPreview) https://img.youtube.com/vi/{{ $ourValuesVideo }}/maxresdefault.jpg @else {{ $ourValuesVideoPreview }} @endif">
                    </div>
                    <iframe width="1280" height="720" src="https://www.youtube.com/embed/{{ $ourValuesVideo }}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

@if(!$shouldHideMap)
<section class="gw-map-btn">
    <div style="background-image: url({{ $mapImage }})" alt-src="{{ $mapAlternativeImage }}">
        <a href="#" id="btn-view-global-work" class="btn btn-info">View Global Work</a>
    </div>
</section>
@endif

@empty(!$actionActive)
    <section class="mb-5 @if($shouldHideMap) mt-5 @else mt-n5 @endif">
        <p class="font-size-20 text-uppercase"><b>{{ $ourValuesInActionTitle ? $ourValuesInActionTitle : 'Our values in action' }}</b></p>
        <div class="black-line"></div>
    </section>
    <section class="values-action new-values-action">
        <div class="row gutter-0">
            <div class="col-7 col-lg-9">
                <div class="tab-content" id="nav-tabContent">
                    @for ($i = 1; $i <= 4; $i++)
                        @if (in_array($i, $actionActive)) <div class="tab-pane fade
                        show @if ($ourValuesActive === false)active @endif"
                            id="nav-panel-{{ $i }}"
                            role="tabpanel">
                            <div class="row gutter-0">
                                <div class="col-0 col-lg-6 img" style="background-image: url('{{ $actionPhoto[$i] }}')">
                                </div>
                                <div class="col-12 col-lg-6 {{ $colorNameClass[$i] }} text">
                                    <div>
                                        <p class="text-1">{!! $actionSlogan[$i] !!}</p>
                                        <p class="text-2">{!! $actionTitle[$i] !!}</p>
                                        <p class="text-3">{!! $actionDescription[$i] !!}</p>
                                        <div><a class="donate-now-link" href="{{ $actionLearnMoreLink[$i] }}"><b>DONATE NOW</b></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                </div>
                @php($ourValuesActive = true)
                @endif
                @endfor
            </div>
        </div>
        <div class="col-5 col-lg-3 values-action-nav">
            <div class="nav flex-column nav-pills" id="nav-tab" role="tablist">
                @for ($i = 1; $i <= 4; $i++)
                    @if (in_array($i, $actionActive)) <a class="nav-link
                    @if ($ourValuesActiveLink === false)active @endif"
                        data-toggle="tab"
                        href="#nav-panel-{{ $i }}"
                        role="tab"
                        aria-selected="true">{{ $actionName[$i] }}</a>
                        @php($ourValuesActiveLink = true)
                    @endif
                @endfor
            </div>
        </div>
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
                        @if (in_array($i, $storyActive)) <div class="swiper-slide
                        d-flex align-items-start">
                        <div class="img-box">
                        <div class="bg-warning">
                        <div class="img"
                        style="background-image: url('{{ ${'storyPhoto' . $i} }}')"></div>
                        </div>
                        </div>
                        <div class="box">
                        <div class="row title">
                        <div class="col-4"><span
                        class="d-inline-block pl-5">{{ ${'storyYear' . $i} }}</span>
                        </div>
                        <div class="col-8 text-right"><span>OUR STORY</span></div>
                        </div>
                        <div class="black-line"></div>
                        <p class="pl-5 pr-5">{!! ${'storyText' . $i} !!}</p>
                        </div>
                        </div> @endif
                    @endfor
                </div>
                <div class="swiper-pagination"></div>
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
    <p class="font-size-45"><b>Life changing support.</b></p>
</section>

@empty(!$changingActive)
    <section class="promo-project-swiper" swiper-wrapper="our-support" swiper-autoHeight="true">
        <div class="wrap @if ($hdrColorType==='blue' ) bg-primary-light @else bg-danger-light @endif">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @for ($i = 1; $i <= 2; $i++)
                        @if (in_array($i, $changingActive)) <div
                        class="swiper-slide">
                        <div class="row gutter-0 align-content-center">
                        <div class="col-6 img"
                        style="background-image: url('{{ ${'lifeChangingPhoto' . $i} }}')">
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

<section class="blog-article-body new-blog-article-body">
    <div class="wrap">
        <div class="body">
            <h2>{{ $lifeChangingBlockTitle }}</h2>
            {!! $lifeChangingBlockText !!}
        </div>
    </div>
</section>

<div class="pt-5 pb-5"></div>

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
    .project-images-carousel .swiper-container {
        width: 100%;
        height: 100%;
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
        bottom: 20px;
    }

    .project-images-carousel .swiper-pagination .swiper-pagination-bullet {
        background: #1b2030;
        border-radius: 0;
        height: 4px;
        width: 65px;
        min-width: 10px;
        margin-right: 10px;
        opacity: 1;
    }

    .project-images-carousel .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active {
        background-color: #F4533C;
    }
</style>
<section class="project-images-carousel mb-4" swiper-wrapper="project-image-carousel" swiper-autoHeight="true">
    <div class="mb-4">
        <b class="font-size-30 mr-4 text-uppercase letter-spacing-1 mb-3">
            Together, with Gaza
        </b>
    </div>
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

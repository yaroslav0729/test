@php

    $bgImage = "";
    $ourMissionTitle = "";
    $ourValuesDescription = "";
    $ourValuesVideo = "";

    for ($i=1; $i<=4; $i++){
        ${'actionName' . $i} = "";
        ${'actionPhoto' . $i} = "";
        ${'actionSlogan' . $i} = "";
        ${'actionTitle' . $i} = "";
        ${'actionDescription' . $i} = "";
        ${'actionLearnMoreLink' . $i} = "";
    }

    $lifeChangingBlockTitle = "";
    $lifeChangingBlockText = "";

    if (isset($parameters['background_image'])) {
        $bgImage = $parameters['background_image'];
    }

    if (isset($parameters['our_values_description'])) {
        $ourValuesDescription = $parameters['our_values_description'];
    }

    if (isset($parameters['our_values_video'])) {
        $ourValuesVideo = $parameters['our_values_video'];
    }

    if (isset($parameters['our_mission_title'])) {
        $ourMissionTitle = $parameters['our_mission_title'];
    }

    $actionActive = $parameters['action_active'] ?? [];

    for ($i=1; $i<=4; $i++){
        if (isset($parameters["action_name_{$i}"])) {
            ${'actionName' . $i} = $parameters["action_name_{$i}"];
        }

        if (isset($parameters["action_photo_{$i}"])) {
            ${'actionPhoto' . $i} = $parameters["action_photo_{$i}"];
        }

        if (isset($parameters["action_slogan_{$i}"])) {
            ${'actionSlogan' . $i} = $parameters["action_slogan_{$i}"];
        }

        if (isset($parameters["action_title_{$i}"])) {
            ${'actionTitle' . $i} = $parameters["action_title_{$i}"];
        }

        if (isset($parameters["action_description_{$i}"])) {
            ${'actionDescription' . $i} = $parameters["action_description_{$i}"];
        }

        if (isset($parameters["action_learn_more_link_{$i}"])) {
            ${'actionLearnMoreLink' . $i} = $parameters["action_learn_more_link_{$i}"];
        }
    }

    if (isset($parameters['changing_block_title'])) {
        $lifeChangingBlockTitle = $parameters['changing_block_title'];
    }
    if (isset($parameters['changing_block_text'])) {
        $lifeChangingBlockText = $parameters['changing_block_text'];
    }

@endphp

<section class="who-we-are-head" style="background-image: url({{ $bgImage }});">
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
                {{--                <div class="img-video" style="background-image: url(img/content/our-values-1.jpg)">
                                    <i class="fas fa-play-circle"></i></div>--}}
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
    <div style="background-image: url(img/map.png)">
        <a href="#" class="btn btn-info">View Global Work</a>
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
                            <div class="tab-pane fade show @if($i === 1)active @endif" id="nav-{{ $i }}"
                                 role="tabpanel">
                                <div class="row gutter-0">
                                    <div class="col-6 img" style="background-image: url({{ ${'actionPhoto' . $i} }})">
                                        &nbsp;
                                    </div>
                                    <div class="col-6 bg-primary-light text">
                                        <div>
                                            <p class="text-1">{!! ${'actionSlogan' . $i} !!}</p>
                                            <p class="text-2">{!! ${'actionTitle' . $i} !!}</p>
                                            <p class="text-3">{!! ${'actionDescription' . $i} !!}</p>
                                            <div><a href="{{ ${'actionLearnMoreLink' . $i} }}"><b>LEARN MORE</b></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endfor
                </div>

            </div>
            <div class="col-3 values-action-nav">
                <div class="nav flex-column nav-pills" id="nav-tab" role="tablist">
                    @for ($i = 1; $i <= 4; $i++)
                        @if(in_array($i, $actionActive ))
                            <a class="nav-link @if($i === 1)active @endif" data-toggle="tab" href="#nav-{{ $i }}"
                               role="tab"
                               aria-selected="true">{{ ${'actionName' . $i} }}</a>
                        @endif
                    @endfor
                </div>

            </div>
        </div>
    </section>
@endempty


<section class="our-story-swiper">
    <div class="wrap">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide d-flex align-items-start">
                    <div class="img-box">
                        <div class="bg-warning">
                            <div class="img"
                                 style="background-image: url(img/content/ibrahim-rifath-lFcTDevfr5k-unsplash.jpg)"></div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="row title">
                            <div class="col-6"><span class="d-inline-block pl-5">2003</span></div>
                            <div class="col-6 text-right"><span>OUR STORY</span></div>
                        </div>
                        <div class="black-line"></div>
                        <p class="pl-5 pr-5">Perspiciais und omnis iste natus error sit voluptatem accusantium
                            doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et
                            quasi architecto beatae vitae dicta sunt explicab. Nemo enim ipsam voluptatem quia voluptas
                            sit aspernatur aut odit aut fugit, sed consequuntur magni dolores eos qui rati voluptate
                            sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet,
                            consectetur, adipisci velit.</p>
                    </div>
                </div>
                <div class="swiper-slide d-flex align-items-start">
                    <div class="img-box">
                        <div class="bg-info">
                            <div class="img"
                                 style="background-image: url(img/content/ibrahim-rifath-lFcTDevfr5k-unsplash2.jpg)"></div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="row title">
                            <div class="col-6"><span class="d-inline-block pl-5">2020</span></div>
                            <div class="col-6 text-right"><span>TODAY</span></div>
                        </div>
                        <div class="black-line"></div>
                        <p class="pl-5 pr-5">Perspiciais und omnis iste natus error sit voluptatem accusantium
                            doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et
                            quasi architecto beatae vitae dicta sunt explicab. Nemo enim ipsam voluptatem quia voluptas
                            sit aspernatur aut odit aut fugit, sed consequuntur magni dolores eos qui rati voluptate
                            sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet,
                            consectetur, adipisci velit.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-button-next"><i class="far fa-arrow-right"></i></div>
        <div class="swiper-button-prev"><i class="far fa-arrow-left"></i></div>
        <div class="swiper-pagination"></div>
    </div>
</section>
<script>
    var swiper = new Swiper('.our-story-swiper .swiper-container', {
        navigation: {
            nextEl: '.our-story-swiper .swiper-button-next',
            prevEl: '.our-story-swiper .swiper-button-prev',
        },
        pagination: {
            el: '.our-story-swiper .swiper-pagination'
        }
    });
</script>


<section class="mb-5">
    <p class="font-size-45"><b>Life changing support.</b></p>
</section>
<section class="promo-project-swiper">
    <div class="wrap">
        <div class="row gutter-0">
            <div class="col-6 img" style="background-image: url(img/content/Image-brace-1.jpg)">
                <a href="#" class="btn btn-info">Donate to this project &nbsp;&nbsp;<i class="fas fa-plus"></i></a>
            </div>
            <div class="col-6 text bg-primary-light">
                756'012 lorem ipsum, dolor excitenum.
                <a href="#" class="prev"><i class="far fa-arrow-left"></i></a>
                <a href="#" class="next"><i class="far fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>


<section class="blog-article-body">
    <div class="wrap">
        <div class="body">
            <h2>{{ $lifeChangingBlockTitle }}</h2>
            {!! $lifeChangingBlockText !!}

        </div>
    </div>
</section>

<div class="pt-5 pb-5"></div>

<section class="discover-more bg-light">
    <div class="wrap">
        <div class="title">
            <div class="row">
                <div class="col-7">
                    <b class="font-size-30 mr-4 text-uppercase">Discover more</b>
                </div>
                <div class="col-5 text-right">
                    <a href="#" class="text-uppercase text-underline"><b>visit newsroom</b> <i
                            class="far fa-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <div class="current-projects-list">
            <div class="row">
                <div class="col-4">
                    <a href="#" class="item">
                        <span class="img" style="background-image: url(img/content/discover-more-1.jpg)"></span>
                        <span class="descr">
                    <span class="name font-size-16">EVENT</span>
                    <span
                        class="text font-size-16"><b>Critical campaign title, 60 char lorem sit amet, demis.</b></span>
                </span>
                    </a>
                </div>
                <div class="col-4">
                    <a href="#" class="item">
                        <span class="img" style="background-image: url(img/content/discover-more-2.jpg)"></span>
                        <span class="descr">
                    <span class="name font-size-16">PROJECT</span>
                    <span
                        class="text font-size-16"><b>Critical campaign title, 60 char lorem sit amet, demis.</b></span>
                </span>
                    </a>
                </div>
                <div class="col-4">
                    <a href="#" class="item">
                        <span class="img" style="background-image: url(img/content/discover-more-3.jpg)"></span>
                        <span class="descr">
                    <span class="name font-size-16">ARTICLE</span>
                    <span
                        class="text font-size-16"><b>Critical campaign title, 60 char lorem sit amet, demis.</b></span>
                </span>
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>


{{--<section class="join-cause-2">
    <div class="wrap">
        <div>
            <div class="row align-items-center">
                <div class="col-7">
                    <div class="title mb-3">
                        <p class="font-size-30"><b>JOIN THE CAUSE</b></p>
                    </div>
                    <p  class="font-size-20 mb-5">There are so many ways to help, make sure you stay in the loop and <a href="#" class="text-underline text-dark">sign up</a> to our Newsletter!</p>
                </div>
                <div class="col-5 pr-4">
                    <img src="img/content/join-cause-2.jpg" alt="" class="w-100">
                    <i class="fal fa-plus decor-plus"></i>
                </div>
            </div>
        </div>
    </div>
</section>--}}

@include('modules.presentation.join_the_cause_subscribe')
{{--@include('modules.presentation.join_the_cause_subscribe2')--}}
@include('modules.presentation.related_pages')


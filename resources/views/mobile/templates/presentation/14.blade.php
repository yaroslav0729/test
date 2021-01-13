@php

    $mainTitle = '';
    $minsText = '';
    $mainText = '';
    $watchLink = '';
    $video = '';

    if (isset($parameters['main_title'])) {
        $mainTitle = $parameters['main_title'];    
    }

    if (isset($parameters['mins_text'])) {
        $minsText = $parameters['mins_text'];    
    }

    if (isset($parameters['main_text'])) {
        $mainText = $parameters['main_text'];    
    }

    if (isset($parameters['watch_link'])) {
        $watchLink = $parameters['watch_link'];    
    }

    if (isset($parameters['main_video'])) {
        $video = $parameters['main_video'];    
    }

@endphp

<section class="newsroom-tabs">
    <nav class="general-content-tabs">
        <div class="nav nav-tabs nav-fill"  role="tablist">
            <a class="nav-link active"  href="#" >TRENDING</a>
            <a class="nav-link "  href="#" >NEWS</a>
            <a class="nav-link "  href="#" >PRESS</a>
            <a class="nav-link "  href="#" >IN CINEMA</a>
        </div>
    </nav>
</section>

<section class="blog-article-head">
    <div class="wrap no-brd pt-0">
        <div class="article-text">
            <div class="img-video videoWrapper" style="background: #aaa">
                @empty($video) 
                    <i class="fas fa-play-circle"></i>
                @endempty
                <iframe width="1280" height="720" src="{{ $video }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <div class="article-text">
                <p class="font-size-12 mb-0"><b>Featured article</b></p>
                <h1 class="mb-3  pb-0">{{ $mainTitle }}</h1>
                <div class="date"><span class="text-danger">{{ $minsText }}</span></div>
                <p>{{ $mainText }}</p>
                <div>
                    <a href="{{ $watchLink }}" class="btn btn-red">Watch now</a>
                </div>
            </div>
        </div>

    </div>
</section>

@include('modules.presentation.trending_articles')

<section class="popular-topic-list">
    <div class="title">
        <b>POPULAR TOPICS</b>
    </div>
        <div class="current-projects-list current-projects-swiper">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <a href="#" class="item">
                            <span class="img" style="background-image: url(img/content/popular-topic-list1.jpg)"></span>
                            <span class="descr">
                                <span class="name font-size-16"><b>CHARITY</b></span>
                                <span class="num">01</span>
                                <span class="text font-size-16 mb-3"><b>Article title placement here with a maximum of 60 characters.</b></span>
                                <span class="date">April 06, 2020 BY AHMED SALEM</span>
                                <i class="moon-icons-plus"></i>
                            </span>
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="#" class="item">
                            <span class="img" style="background-image: url(img/content/popular-topic-list2.jpg)"></span>
                            <span class="descr">
                                <span class="name font-size-16"><b>EVENT</b></span>
                                <span class="num">02</span>
                                <span class="text font-size-16 mb-3"><b>Article title placement here with a maximum of 60 characters.</b></span>
                                <span class="date">April 06, 2020 BY AHMED SALEM</span>
                                <i class="moon-icons-plus"></i>
                            </span>
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="#" class="item">
                            <span class="img" style="background-image: url(img/content/popular-topic-list3.jpg)"></span>
                            <span class="descr">
                                <span class="name font-size-16"><b>PROJECT</b></span>
                                <span class="num">03</span>
                                <span class="text font-size-16 mb-3"><b>Article title placement here with a maximum of 60 characters.</b></span>
                                <span class="date">April 06, 2020 BY AHMED SALEM</span>
                                <i class="moon-icons-plus"></i>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

        <script>
            var swiper = new Swiper('.current-projects-swiper .swiper-container', {
                pagination: {
                    el: '.current-projects-swiper .swiper-pagination'
                }
            });
        </script>
</section>

<section class="mission-impossible">
    <div class="title no-brd">Mission Impossible</div>
    <div class="wrap">
        <div class="body">
            <div class="text bg-danger">
                <div class="tl">Applications for MP 2020 deployments are open!</div>
            </div>
            <div class="img" style="background-image: url(img/content/project-2.jpg)">&nbsp;</div>
            <div class="text-center bg-danger-light">
                <a href="#" class="btn btn-danger-light view-more">Learn more</a>
            </div>
        </div>
    </div>
</section>

{{-- <section class="join-cause pb-0 with-glyph">
    <div class="wrap">
        <div class="title text-center">
            <p class="font-size-25"><b>Join the cause!</b></p>
        </div>
        <p class="font-size-20 mb-4  text-center">
            There are so many ways to help, stay in the loop with our Newsletter.
        </p>
        <form action="/" class="d-flex">
            <input type="text" placeholder="Your email address" class="flex-grow-1">
            <button type="submit"><i class="far fa-chevron-right"></i></button>
        </form>
        <div class="pt-4"></div>
    </div>
</section> --}}

@include('modules.presentation.join_the_cause_subscribe', [
    'disableImageBefore' => true
])


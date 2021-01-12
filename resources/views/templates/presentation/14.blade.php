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
    <div class="wrap no-brd">
        <div class="row">
            <div class="col-5 article-text">
                <p class="font-size-12 mb-0"><b>Featured article</b></p>
                <h1>Today's empowering watch.</h1>
                <h1 class="no-line mb-0">{{ $mainTitle }}</h1>
                <div class="date"><span class="text-danger">{{ $minsText }}</span></div>
                <p>{{ $mainText }}</p>
                <div>
                    <a href="{{ $watchLink }}" class="btn btn-red">Watch now</a>
                </div>
            </div>
            <div class="col-1"></div>
            <div class="col-6">
                <div class="img-video videoWrapper" style="background: #aaa">
                    @empty($video) 
                        <i class="fas fa-play-circle"></i>
                    @endempty
                    <iframe width="1280" height="720" src="{{ $video }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

@include('modules.presentation.trending_articles')

<div class="pt-5 pb-5"></div>

<section class="popular-topic-list">
    <div class="title">
        <b class="font-size-30 mr-4 text-uppercase">POPULAR TOPICS</b>
    </div>
    <div class="row gutter-5">
        <div class="col-4">
            <div class="num">01</div>
            <a href="#" class="item">
                <span class="img" style="background-image: url(img/content/popular-topic-list1.jpg)"></span>
                <span class="descr">
                    <span class="name font-size-16"><b>CHARITY</b></span>
                    <span class="text font-size-20 mb-3"><b>Article title placement here with a maximum of 60 characters.</b></span>
                    <span class="date">April 06, 2020 BY AHMED SALEM</span>
                    <i class="moon-icons-plus"></i>
                </span>
            </a>
        </div>
        <div class="col-4">
            <div class="num">02</div>
            <a href="#" class="item">
                <span class="img" style="background-image: url(img/content/popular-topic-list2.jpg)"></span>
                <span class="descr">
                    <span class="name font-size-16"><b>EVENT</b></span>
                    <span class="text font-size-20 mb-3"><b>Article title placement here with a maximum of 60 characters.</b></span>
                    <span class="date">April 06, 2020 BY AHMED SALEM</span>
                    <i class="moon-icons-plus"></i>
                </span>
            </a>
        </div>
        <div class="col-4">
            <div class="num">03</div>
            <a href="#" class="item">
                <span class="img" style="background-image: url(img/content/popular-topic-list3.jpg)"></span>
                <span class="descr">
                    <span class="name font-size-16"><b>PROJECT</b></span>
                    <span class="text font-size-20 mb-3"><b>Article title placement here with a maximum of 60 characters.</b></span>
                    <span class="date">April 06, 2020 BY AHMED SALEM</span>
                    <i class="moon-icons-plus"></i>
                </span>
            </a>
        </div>
    </div>
</section>

@include('modules.presentation.join_the_cause_subscribe')



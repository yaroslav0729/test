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
            <a class="nav-link active" data-active="newsroom_tab_trending"  href="#" >TRENDING</a>
            <a class="nav-link" data-active="newsroom_tab_news" href="#" >NEWS</a>
            <a class="nav-link" data-active="newsroom_tab_press" href="#" >PRESS</a>
            <a class="nav-link" data-active="newsroom_tab_cinema" href="#" >IH CINEMA</a>
        </div>
    </nav>
</section>

{{--

newsroom_tab_trending
newsroom_tab_news
newsroom_tab_press
newsroom_tab_cinema

--}}

<section class="blog-article-head newsroom_tab_trending">
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

<div class="newsroom_tab_trending 
newsroom_tab_news 
newsroom_tab_press 
newsroom_tab_cinema">
    @include('modules.presentation.trending_articles')
</div>

<div class="pt-5 pb-5"></div>

<div class="newsroom_tab_trending 
newsroom_tab_news 
newsroom_tab_press 
newsroom_tab_cinema">
    @include('modules.presentation.popular_topics')
</div>

<div class="newsroom_tab_trending">
    @include('modules.presentation.mission_possible')
</div>

@include('modules.presentation.join_the_cause_subscribe')



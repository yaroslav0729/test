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
            <a class="nav-link "  href="#" >IH CINEMA</a>
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

@include('modules.presentation.popular_topics')

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


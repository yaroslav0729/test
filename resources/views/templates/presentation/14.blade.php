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

    use \App\Helpers\ArticlesHelper;
    $newsroomPath = \App\Models\Page::getNewsroomPage() ? \App\Models\Page::getNewsroomPage()->slug : '';

    $currentTab = 1;

    if (request()->get(ArticlesHelper::TRENDING_PAGINATOR) !== null) {
        $currentTab = 1;
    }
    if (request()->get(ArticlesHelper::NEWS_PAGINATOR)!== null) {
        $currentTab = 2;
    }
    if (request()->get(ArticlesHelper::PRESS_PAGINATOR)!== null) {
        $currentTab = 3;
    }

@endphp

<section class="newsroom-tabs">
    <nav class="general-content-tabs">
        <div class="nav nav-tabs nav-fill" role="tablist">
            <a class="nav-link @if($currentTab === 1) active @endif" data-active="newsroom_tab_trending" href="#">TRENDING</a>
            <a class="nav-link @if($currentTab === 2) active @endif" data-active="newsroom_tab_news" href="#">NEWS</a>
            <a class="nav-link @if($currentTab === 3) active @endif" data-active="newsroom_tab_press" href="#">PRESS</a>
            <a class="nav-link @if($currentTab === 4) active @endif" data-active="newsroom_tab_cinema" href="#">IH
                CINEMA</a>
        </div>
    </nav>
</section>

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
                        <iframe width="1280" height="720" src="https://www.youtube.com/embed/{{ $video }}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                        </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="newsroom_tab_trending newsroom-tab-by-sort">
    @php
        $page = (int) request()->get('trending_articles');

        $articles = ArticlesHelper::getNewsroomTrendingArticles($page);
        $articles->withPath(url($newsroomPath));

    @endphp

    @include('modules.presentation.newsroom_articles', [
        'articles' => $articles,
        'titleSpan' => 'Trending',
        'titleI' => 'Trending articles'
    ])

</div>

<div class="newsroom_tab_news mt-4 newsroom-tab-by-sort">

    @php
        $page = (int) request()->get('news_articles');

        $articles = ArticlesHelper::getNewsroomNewsArticles($page);
        $articles->withPath(url($newsroomPath));

    @endphp

    @include('modules.presentation.newsroom_articles', [
        'articles' => $articles,
        'titleSpan' => 'News',
        'titleI' => 'News articles'
    ])
</div>

<div class="newsroom_tab_press newsroom-tab-by-sort">

    @php
        $page = (int) request()->get('press_articles');

        $articles = ArticlesHelper::getNewsroomPressArticles($page);
        $articles->withPath(url($newsroomPath));

    @endphp

    @include('modules.presentation.newsroom_articles', [
        'articles' => $articles,
        'titleSpan' => 'Press',
        'titleI' => 'Press'
    ])
</div>

<div class="pt-5 pb-5"></div>

<div class="newsroom_tab_trending
newsroom_tab_news
newsroom_tab_press
newsroom_tab_cinema">
    @include('modules.presentation.popular_topics')
</div>

<div class="newsroom_tab_trending mt-5 pt-5">
    @include('modules.presentation.mission_possible')
</div>

@include('modules.presentation.join_the_cause_subscribe')



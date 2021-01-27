@php

if (isset($selectedPage)) {
    $page = $selectedPage;
} else {
    $page = (int) request()->get('trending_articles');
}

$articles = \App\Helpers\ArticlesHelper::getNewsroomArticles($page);

@endphp

<section class="newsroom-list" trending-articles>
    <div class="title">
        <span id="newsroom_title_span">Trending</span>
        <i id="newsroom_title_i">Trending articles</i>
        <div>
            <button class="btn btn-white">SORT BY DATE</button>
            <button class="btn btn-primary-dark">FILTER BY TOPIC</button>
        </div>
    </div>

    <div class="pt-5 pb-5"></div>

    <div class="row gutter-30" trending-articles-body>
        @foreach ($articles as $article)
            @php
                $item = $article->actual_page_instance;    
            @endphp
            <div class="col-12 col-md-6">
                <div class="item">
                    <div>
                        <a href="{{ $item->slug }}" class="tl">{!! \App\Helpers\StrHelper::lengthLimit($item->title, 50) !!}</a>
                        <p>{!! \App\Helpers\StrHelper::lengthLimit($item->preview_text, 40) !!}</p>
                        <div class="date" style="text-transform: uppercase">
                            {{ date('d F', strtotime($item->published_at)) }}<span>•</span>BY AHMED SALEM<span>•</span><b>{{ \App\Helpers\ArticlesHelper::getMinRead($item) }}min read</b>
                        </div>
                    </div>
                    <a href="{{ $item->slug }}" class="img" style="background-image: url({{ $item->preview_img }})"></a>
                </div>
            </div>    
        @endforeach
    </div>

    <div class="pt-5 pb-5"></div>

    <ul class="pagination justify-content-center" trending-articles-pagination>
        {{ $articles->links('parts.custom_paginator') }}
    </ul>
</section>
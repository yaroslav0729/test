@php

$page = (int) request()->get('trending_articles');
$articles = \App\Helpers\ArticlesHelper::getNewsroomArticles($page);

@endphp

<section class="newsroom-list" >
    <div class="title">
        <div>
            <span>Trending</span>
            <i>Trending articles</i>
        </div>
        <div>
            <button class="btn btn-white">SORT BY DATE</button>
            <button class="btn btn-primary-dark">FILTER BY TOPIC</button>
        </div>
    </div>

    <div class="row">
        @foreach ($articles as $article)
            @php
                $item = $article->actual_page_instance;    
            @endphp

            <div class="col-12">
                <div class="item">
                    <div>
                        <a href="{{ $item->slug }}" class="tl">{{ \App\Helpers\StrHelper::lengthLimit($item->title, 50) }}</a>
                        <div class="date">
                            <div><b>{{ \App\Helpers\ArticlesHelper::getMinRead($item) }}min read</b></div>
                            {{ date('d F', strtotime($pageInstance->published_at)) }}
                            <span>•</span>BY AHMED SALEM
                        </div>
                    </div>
                    <a href="{{ $item->slug }}" class="img" style="background-image: url(img/content/explore-past-missions1.jpg)"></a>
                </div>
            </div>
        @endforeach
        
    </div>

    <div class="pt-3 pb-3"></div>

    <ul class="pagination justify-content-center">
        {{ $articles->onEachSide(0)->links('parts.custom_paginator') }}
    </ul>
</section>
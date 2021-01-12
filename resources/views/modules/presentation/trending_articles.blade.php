@php

$articles = \App\Helpers\ArticlesHelper::getNewsroomArticles();
    
@endphp

<div class="alert alert-warning">
    @php
        //dd($articles);
    @endphp
</div>

<section class="newsroom-list">
    <div class="title">
        <span>Trending</span>
        <i>Trending articles</i>
        <div>
            <button class="btn btn-white">SORT BY DATE</button>
            <button class="btn btn-primary-dark">FILTER BY TOPIC</button>
        </div>
    </div>

    <div class="pt-5 pb-5"></div>

    <div class="row gutter-30">
        @foreach ($articles as $article)
            @php
                $item = $article->actual_page_instance;    
            @endphp
            <div class="col-12 col-md-6">
                <div class="item">
                    <div>
                        <a href="{{ $item->slug }}" class="tl">{{ \App\Helpers\StrHelper::lengthLimit($item->title, 50) }}</a>
                        <p>{{ \App\Helpers\StrHelper::lengthLimit($item->preview_text, 40) }}</p>
                        <div class="date" style="text-transform: uppercase">
                            {{ date('d F', strtotime($pageInstance->published_at)) }}<span>•</span>BY AHMED SALEM<span>•</span><b>{{ \App\Helpers\ArticlesHelper::getMinRead($item) }}min read</b>
                        </div>
                    </div>
                    <a href="{{ $item->slug }}" class="img" style="background-image: url({{ $item->preview_img }})"></a>
                </div>
            </div>    
        @endforeach
    </div>

    <div class="pt-5 pb-5"></div>

    <ul class="pagination justify-content-center">
        <li class="page-item">
            <a class="page-link arrow" href="#" aria-label="Previous">
                <i class="far fa-chevron-left"></i>
            </a>
        </li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
            <a class="page-link arrow" href="#" aria-label="Next">
                <i class="far fa-chevron-right"></i>
            </a>
        </li>
    </ul>
</section>
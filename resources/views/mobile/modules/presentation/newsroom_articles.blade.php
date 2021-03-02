<section class="newsroom-list" newsroom-articles>
    <div class="newsroom-list-title">
        <div>
            <span>{{ $titleSpan }}</span>
            <i>{{ $titleI }}</i>
        </div>
    </div>
    <div class="row mb-4 gutter-5 filter-btns">
        <div class="col-6">
            <button class="btn btn-white w-100">SORT BY DATE</button>
        </div>
        <div class="col-6">
            <button class="btn btn-primary-dark w-100">FILTER BY TOPIC</button>
        </div>
    </div>

    <div class="row" newsroom-articles-body>
        @foreach ($articles as $article)
            @php
                $item = $article->actual_page_instance;    
            @endphp

            <div class="col-12">
                <div class="item">
                    <div>
                        <a href="{{ $item->slug }}" class="tl">{!! \App\Helpers\StrHelper::lengthLimit($item->title, 50) !!}</a>
                        <div class="date">
                            <div><b>{{ \App\Helpers\ArticlesHelper::getMinRead($item) }}min read</b></div>
                            {{ date('d F', strtotime($item->published_at)) }}
                            <span>•</span>BY AHMED SALEM
                        </div>
                    </div>
                    <a href="{{ $item->slug }}" class="img" style="background-image: url({{ $item->preview_img }})"></a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="pt-3 pb-3"></div>

    <ul class="pagination justify-content-center" newsroom-articles-pagination>
        {{ $articles->onEachSide(0)->links('parts.custom_paginator') }}
    </ul>
</section>
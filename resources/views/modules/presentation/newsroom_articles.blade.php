<section class="newsroom-list" newsroom-articles>
    @isset($titleSpan)
    <div class="newsroom-list-title mt-4">
        <span id="newsroom_title_span">{{ $titleSpan }}</span>
        <i id="newsroom_title_i">{{ $titleI }}</i>
        <div>
            <button class="btn btn-white btn-newsroom text-decoration-none letter-spacing-1 btn-active" data-sort="date">SORT BY DATE</button>
            <button class="btn btn-primary-dark btn-newsroom text-decoration-none letter-spacing-1" data-sort="topic">FILTER BY TOPIC</button>
        </div>
    </div>
    @endisset

    <div class="row gutter-30 mt-4" newsroom-articles-body>
        @foreach ($articles as $article)
            @php
                $item = $article->actual_page_instance;
            @endphp
            <div class="col-12 col-md-6">
                <div class="item">
                    <div>
                        <a href="{{ $item->slug }}"
                           class="tl">{!! \App\Helpers\StrHelper::lengthLimit($item->title, 50) !!}</a>
                        <p>{!! \App\Helpers\StrHelper::lengthLimit($item->preview_text, 40) !!}</p>
                        <div class="date" style="text-transform: uppercase">
                            {{ date('F d', strtotime($item->published_at)) }}<span>•</span>BY AHMED
                            SALEM<span>•</span><b
                                class="text-lowercase">{{ \App\Helpers\ArticlesHelper::getMinRead($item) }}min read</b>
                        </div>
                    </div>
                    <a href="{{ $item->slug }}" class="img" style="background-image: url({{ $item->preview_img }})"></a>
                </div>
            </div>
        @endforeach
    </div>
    <div class="pt-5 pb-5"></div>

    <ul class="pagination justify-content-center" newsroom-articles-pagination>
        {{ $articles->links('parts.custom_paginator') }}
    </ul>
</section>

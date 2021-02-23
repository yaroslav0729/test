@php
    $popularTopics = \App\Helpers\ArticlesHelper::getPopularTopics();
@endphp

<section class="popular-topic-list">
    <div class="title">
        <b class="font-size-30 mr-4 text-uppercase">POPULAR TOPICS</b>
    </div>
    <div class="row gutter-5">
        @foreach ($popularTopics as $key => $article)
            @php
                $topic = $article->actual_page_instance;
            @endphp
            <div class="col-4">
                <div class="num">0{{ $key +1 }}</div>
                <a href="{{ $topic->slug }}" class="item">
                    <span class="img" style="background-image: url({{ $topic->preview_img }})"></span>
                    <span class="descr d-flex flex-column justify-content-between">
                        <span class="name font-size-16 d-block"><b>{{ \App\Helpers\StrHelper::lengthLimit($topic->preview_text, 50) }}</b></span>
                        <span class="text font-size-20 mb-3 mt-5 d-block"><b>{{ \App\Helpers\StrHelper::lengthLimit($topic->title, 60) }}</b></span>
                        <span class="date d-block mb-2">{{ date('F d, Y', strtotime($topic->published_at)) }}, BY AHMED SALEM</span>
                        <i class="moon-icons-plus"></i>
                    </span>
                </a>
            </div>
        @endforeach
    </div>
</section>

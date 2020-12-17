<section class="general-content-head bg-light">
    <div class="wrap">
        <div class="img">
            <img src="{{ $pageInstance->preview_img }}" alt="">
        </div>
        <div class="pl-4 pr-4">
            <h1>{{ $pageInstance->preview_text }}</h1>
            <div class="date">
                <i></i>{{ date('d F Y', strtotime($pageInstance->published_at)) }}
            </div>
        </div>
    </div>
</section>
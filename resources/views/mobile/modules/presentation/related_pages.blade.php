@php
    $relPageCatId = "";
    $bgClass = '';

    if (isset($parameters['rel_page_category'])) {
        $relPageCatId = (int)$parameters['rel_page_category'];
    }

    $relatedPages = \App\Models\Module::getRelatedPages($relPageCatId);

    if (isset($parameters['bg_rel_class'])) {
        $bgClass = $parameters['bg_rel_class'];
    }

@endphp

<section class="discover-more @empty($bgClass) bg-light @else {{ $bgClass }} @endempty">
    <div class="wrap">
        <div class="title">
            <b class="font-size-25 text-uppercase">Related topics</b>
        </div>
        <div class="current-projects-list current-projects-swiper" swiper-wrapper="rel_pages">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach ($relatedPages as $page)
                        <div class="swiper-slide">
                            <a href="{{ $page->slug }}" class="item">
                                @isset($page->preview_img)
                                <span class="img" style="background-image: url({{ $page->preview_img }})"></span>
                                @else
                                <span class="img" style="background: #eee"></span>
                                @endisset

                                <span class="descr">
                                <span class="name font-size-16">{{ $page->name }}</span>
                                <span class="text font-size-16"><b>{{ $page->preview_text }}</b></span></span>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</section>

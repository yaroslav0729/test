@php
    $bgClass = "";

    if (isset($parameters['bg_class'])) {
        $bgClass = $parameters['bg_class'];
    }

    $pageIds = [];

    if (isset($parameters['proj_rel_page_1'])) {
        $pageIds[] = $parameters['proj_rel_page_1'];
    }
    if (isset($parameters['proj_rel_page_2'])) {
        $pageIds[] = $parameters['proj_rel_page_2'];
    }
    if (isset($parameters['proj_rel_page_3'])) {
        $pageIds[] = $parameters['proj_rel_page_3'];
    }

    $pages = \App\Models\Project::getRelPages($pageIds);

@endphp

<section class="discover-more @empty($bgClass) bg-light @else {{ $bgClass }} @endempty">
    <div class="wrap">
        <div class="title">
            <b class="font-size-25 text-uppercase">Related topics</b>
        </div>
        <div class="current-projects-list current-projects-swiper" swiper-wrapper="rel_pages">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach ($pages as $page)
                        <div class="swiper-slide">
                            <a href="{{ url($page->slug) }}" class="item">
                                @isset($page->preview_img)
                                <span class="img" style="background-image: url({{ url($page->preview_img) }})"></span>
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

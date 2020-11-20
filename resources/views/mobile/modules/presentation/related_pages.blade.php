@php
    $relPageCatId = "";

    if (isset($parameters['rel_page_category'])) {
        $relPageCatId = (int)$parameters['rel_page_category'];
    }

    $relatedPages = \App\Models\Module::getRelatedPages($relPageCatId);
@endphp

<div class="current-projects-list current-projects-swiper" swiper-wrapper="related">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @foreach ($relatedPages as $page)
                <div class="swiper-slide">
                    <a href="#" class="item">
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

{{-- <script>
    var swiper = new Swiper('.current-projects-swiper .swiper-container', {
        pagination: {
            el: '.current-projects-swiper .swiper-pagination'
        }
    });
</script> --}}

@php
    $relPageCatId = "";

    if (isset($parameters['rel_page_category'])) {
        $relPageCatId = (int)$parameters['rel_page_category'];
    }

    $relatedPages = \App\Models\Module::getRelatedPages($relPageCatId);
@endphp

<div class="current-projects-list">
    <div class="wrap">
        <div class="row gutter-5">
            @foreach ($relatedPages as $page)
                <div class="col-4">
                    <a href="{{ $page->slug }}" class="item">
                        @isset($page->preview_img)
                            <span class="img" style="background-repeat:no-repeat; background-image: url(/{{ $page->preview_img }})"></span>
                        @else
                            <span class="img" style="background: #eee"></span>
                        @endisset

                        <span class="descr">
                        <span class="name font-size-16"><b>{{ \App\Helpers\StrHelper::lengthLimit($page->name, 20) }}</b></span>
                        <span class="text font-size-16">{{ \App\Helpers\StrHelper::lengthLimit($page->preview_text, 60) }}</span>
                        </span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>

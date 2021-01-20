@php
    $relPageTitle = "";
    $relPageLinkTitle = "";
    $relPageLink = "";
    $bgClass = "";

    if (isset($parameters['rel_page_title'])) {
        $relPageTitle = $parameters['rel_page_title'];
    }

    if (isset($parameters['rel_page_link_title'])) {
        $relPageLinkTitle = $parameters['rel_page_link_title'];
    }

    if (isset($parameters['rel_page_link'])) {
        $relPageLink = $parameters['rel_page_link'];
    }

    if (isset($parameters['bg_class'])) {
        $bgClass = $parameters['bg_class'];
    }

@endphp

<section class="discover-more @empty($bgClass) bg-light @else {{ $bgClass }} @endempty">
    <div class="wrap">
        <div class="title">
            <div class="row">
                <div class="col-7">
                    <b class="font-size-30 mr-4 text-uppercase">
                        @if ($relPageTitle === "")
                            DISCOVER MORE
                        @else
                            {{ $relPageTitle }}
                        @endif
                    </b>
                </div>
                <div class="col-5 text-right">
                    <a href="
                    @if ($relPageLink === "")
                        /blog-page
                    @else
                        {{ $relPageLink }}
                    @endif
                        " class="text-uppercase text-underline">
                        <b>
                            @if ($relPageLinkTitle === "")
                                VISIT NEWSROOM
                            @else
                                {{ $relPageLinkTitle }}
                            @endif

                        </b> <i class="moon-icons-arrow-right"></i></a>
                </div>
            </div>
        </div>
        @include('modules.presentation.related_pages', [
            'parameters' => $parameters,
        ])
    </div>
</section>

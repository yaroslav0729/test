@php
    $relPageTitle = "";
    $relPageLinkTitle = "";
    $relPageLink = "";

    if (isset($parameters['rel_page_title'])) {
        $relPageTitle = $parameters['rel_page_title'];
    }

    if (isset($parameters['rel_page_link_title'])) {
        $relPageLinkTitle = $parameters['rel_page_link_title'];
    }

    if (isset($parameters['rel_page_link'])) {
        $relPageLink = $parameters['rel_page_link'];
    }
@endphp

<section class="discover-more bg-light">
    <div class="wrap">
        <div class="title">
            <b class="font-size-25 text-uppercase d-inline-block mb-3">{{ $relPageTitle }}</b>
        </div>
        @include('modules.presentation.related_pages', [
            'parameters' => $parameters
        ])
    </div>
</section>

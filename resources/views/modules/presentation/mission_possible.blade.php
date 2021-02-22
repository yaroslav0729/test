@php

    $previewPageTitle = "";
    $previewPageText1 = "";
    $previewPageText2 = "";
    $previewPageLink = "";
    $previewPageImage = "";

    if (isset($parameters['preview_page_title'])) {
        $previewPageTitle = $parameters['preview_page_title'];
    }

    if (isset($parameters['preview_page_text1'])) {
        $previewPageText1 = $parameters['preview_page_text1'];
    }

    if (isset($parameters['preview_page_text2'])) {
        $previewPageText2 = $parameters['preview_page_text2'];
    }

    if (isset($parameters['preview_page_link'])) {
        $previewPageLink = $parameters['preview_page_link'];
    }

    if (isset($parameters['preview_page_image'])) {
        $previewPageImage = $parameters['preview_page_image'];
    }

@endphp

<section class="mission-impossible">
    <div class="wrap">
        @empty($previewPageTitle)
        <div class="title">Mission possible</div>
        @else
        <div class="title">{{ $previewPageTitle }}</div>
        @endempty

    </div>
    <div class="wrap">
    <div class="body">
        <div class="row gutter-0">
            <div class="col-7" style="z-index: 2">
                <div class="text bg-danger">
                    @empty($previewPageText1)
                    <div class="tl">Mission Possible, the mission that changes everyone's lives. </div>
                    @else
                    <div class="tl">{{ $previewPageText1 }}</div>
                    @endempty

                    @empty($previewPageText2)
                    <p>Donate a water pump or well to those in need around the world and request a personalised plaque upon checkout</p>
                    @else
                    <p>{{ $previewPageText2 }}</p>
                    @endempty
                </div>
                <div class="text-right">
                    <a href="{{ $previewPageLink }}" class="btn btn-danger-light view-more">Learn more</a>
                </div>
            </div>
            @empty($previewPageImage)
            <div class="col-5 img" style="background-image: url(img/content/mission-impossible-1.jpg)">&nbsp;</div>
            @else
            <div class="col-5 img" style="background-image: url({{ $previewPageImage }})">&nbsp;</div>
            @endempty
        </div>
    </div>
    </div>
</section>

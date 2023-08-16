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
    <div class="title">
        @empty($previewPageTitle)
           Mission Possible
        @else
            {{ $previewPageTitle }}
        @endempty

    </div>
    <div class="wrap">
        <div class="body">
            <div class="text bg-danger">
                <div class="tl">
                    @empty($previewPageText1)
                        Applications for Mission Possible 2020 deployments are open!
                    @else
                        {{ $previewPageText1 }}
                    @endempty
                </div>
            </div>
            @empty($previewPageImage)
                <div class="img" style="background-image: url(img/content/mission-impossible-1.jpg)">&nbsp;</div>
            @else
                <div class="img" style="background-image: url({{ $previewPageImage }})">&nbsp;</div>
            @endempty
            <div class="text-center bg-danger-light">
                <a href="{{ $previewPageLink }}" class="btn btn-danger-light view-more">Learn more</a>
            </div>
        </div>
    </div>
</section>


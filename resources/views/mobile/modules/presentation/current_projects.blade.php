@php
    $slideTitle = [];
    $slideText = [];
    $readMoreLink = [];
    $donateNowLink = [];
    $slideImage = [];

    if (isset($parameters['feat_camp_link'])) {
        $featuredCompaignLink = $parameters['feat_camp_link'];
    }

    for ($i = 0; $i < 4; $i++) {
        if (isset($parameters['slide_title_' . $i])) {
            $slideTitle[$i] = $parameters['slide_title_' . $i];
        } else {
            $slideTitle[$i] = "";
        }

        if (isset($parameters['slide_text_' . $i])) {
            $slideText[$i] = $parameters['slide_text_' . $i];
        } else {
            $slideText[$i] = "";
        }

        if (isset($parameters['slide_img_' . $i])) {
            $slideImage[$i] = $parameters['slide_img_' . $i];
        } else {
            $slideImage[$i] = "";
        }

        if (isset($parameters['read_more_link_' . $i])) {
            $readMoreLink[$i] = $parameters['read_more_link_' . $i];
        } else {
            $readMoreLink[$i] = "";
        }

        if (isset($parameters['donate_now_link_' . $i])) {
            $donateNowLink[$i] = $parameters['donate_now_link_' . $i];
        } else {
            $donateNowLink[$i] = "";
        }
    }


@endphp

<section class="current-projects" swiper-wrapper="slider-mobile-1" swiper-autoHeight="true">
    <div class="wrap">
        <div class="title">
            <span>Current Projects</span>
            <i class="moon-icons-arrow-down"></i>
        </div>

        <div class="swiper-container">
            <div class="swiper-wrapper">
                @for ($i = 0; $i < 4; $i++)
                <div class="swiper-slide">
                    <div class="body">
                        <div class="left">
                            <p class="font-size-20 mb-3 text-uppercase"><b>{!! $slideTitle[$i] !!}</b></p>
                            <p class="font-size-14 mb-2">{!! $slideText[$i] !!}</p>
                            <div>
                                <a href="{{ $donateNowLink[$i] }}" class="btn btn-warning">Donate now</a>
                            </div>
                        </div>
                        <div class="img" style="background-image: url('{{ $slideImage[$i] }}')"></div>
                    </div>
                </div>
                @endfor
            </div>
            <div class="swiper-button-prev"><i class="moon-icons-arrow-left"></i></div>
            <div class="swiper-button-next"><i class="moon-icons-arrow-right"></i></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

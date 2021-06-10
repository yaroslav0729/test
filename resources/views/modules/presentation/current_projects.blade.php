@php
    $featuredCompaignLink = "";
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

<div class="current-projects-slider">

    <section class="current-projects">

        <div class="wrap">
            <div class="title">
                <span>Current Projects</span>
                <a href="{{ $featuredCompaignLink }}" class="text-underline text-dark letter-spacing-1"><b>FEATURED
                        CAMPAIGN</b></a>
                <i class="moon-icons-arrow-down"></i>
            </div>

            <div swiper-wrapper="current_projects" class="box-1">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @for($i = 0; $i < 4; $i++)
                            <div class="swiper-slide">
                                <div class="body">
                                    <div class="row gutter-0">
                                        <div class="col-12 col-lg-6">
                                            <div class="left">
                                                <div class="text">
                                                    <p class="font-size-30 mb-4 font-weight-bold text-uppercase slide-title">{{ $slideTitle[$i] }}</p>
                                                    <p class="font-size-16 mb-5 slide-text">{{ $slideText[$i] }}</p>
                                                    <div class="actions">
                                                        <a href="{{ $readMoreLink[$i] }}"
                                                           class="btn btn-outline-primary slide-readmore">Read
                                                            more</a>
                                                        <a href="{{ $donateNowLink[$i] }}" class="btn btn-primary">Donate
                                                            now</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="img" style="background-image: url({{ $slideImage[$i] }})"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endfor
                    </div>
                </div>

                <a href="#" class="view-more swiper-button-next"><i class="moon-icons-arrow-right"></i></a>
            </div>
        </div>
    </section>

</div>

@php
    $slideTitle = [];
    $slideText = [];
    $readMoreLink = [];
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
    }
    

@endphp

<section class="current-projects">
    <div class="wrap">
        <div class="title">
            <span>Current Projects</span>
            <i class="far fa-arrow-down"></i>
        </div>

        <div class="swiper-container">
            <div class="swiper-wrapper">
                @for ($i = 0; $i < 4; $i++)
                    <div class="swiper-slide">
                        <div class="body">
                            <div class="left">
                                <p class="font-size-20 mb-3">{{ $slideTitle[$i] }}</p>
                                <p class="font-size-15 mb-2">{{ $slideText[$i] }}</p>
                                <div>
                                    <a href="#" class="btn btn-warning">Donate now</a>
                                </div>
                            </div>
                            <div class="img" style="background-image: url({{ $slideImage[$i] }})"></div>
                        </div>
                    </div>   
                @endfor
            </div>
            <div class="swiper-button-next"><i class="fal fa-arrow-right"></i></div>
            <div class="swiper-button-prev"><i class="far fa-arrow-left"></i></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
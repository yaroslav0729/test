@php
    $featuredCompaignLink = "";
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

<div class="current-projects-slider">

<section class="current-projects">
    <div class="wrap">
        <div class="title">
            <span>Current Projects</span>
            <a href="{{ $featuredCompaignLink }}" class="text-underline text-dark view-more"><b>FEATURED CAMPIGN</b></a>
            <i class="far fa-arrow-down"></i>
        </div>
        <div class="body">
            <div class="row gutter-0">
                <div class="col-6">
                    <div class="left">
                        <p class="font-size-30 mb-3 font-weight-bold text-uppercase slide-title">{{ $slideTitle[0] }}</p>
                        <p class="font-size-16 mb-5 slide-text">{{ $slideText[0] }}</p>
                        <div>
                            <a href="{{ $readMoreLink[0] }}" class="btn btn-outline-primary mr-4 slide-readmore">Read more</a>
                            <a href="#" class="btn btn-primary">Donate now</a>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="img slide-img" style="background-image: url({{ $slideImage[0] }})">
                        <a href="#" id="current-proj-next-slide" class="view-more"><i class="far fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="current-projects-list">
    <div class="wrap">
        <div class="row">
            @for ($i = 1; $i < 4; $i++)
                <div class="col-4 slide_{{ $i }}">
                    <a href="#" class="item">
                        <span class="img slide-img" style="background-image: url({{ $slideImage[$i] }})"></span>
                        <span class="descr">
                            <span class="name font-weight-bold  font-size-16 slide-title">{{ $slideTitle[$i] }}</span>
                            <span class="text font-size-16 slide-text">{{ $slideText[$i] }}</span>
                        </span>
                    </a>
                </div>
            @endfor
        </div>
    </div>
</section>

<div class="d-none slider_data">
    @for ($i = 0; $i < 4; $i++)
        <div class="slide_{{ $i }}">
            <div class="slider_data_title">{{ $slideTitle[$i] }}</div>
            <div class="slider_data_text">{{ $slideText[$i] }}</div>
            <div class="slider_data_img">{{ $slideImage[$i] }}</div>
            <div class="slider_data_readmore">{{ $readMoreLink[$i] }}</div>
        </div>
    @endfor
</div>

</div>
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
                        <p class="font-size-30 mb-3"><b>{{ $slideTitle[0] }}</b></p>
                        <p class="font-size-16 mb-5">{{ $slideText[0] }}</p>
                        <div>
                            <a href="{{ $readMoreLink[0] }}" class="btn btn-outline-primary mr-4">Read more</a>
                            <a href="#" class="btn btn-primary">Donate now</a>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="img" style="background-image: url({{ $slideImage[0] }})">
                        <a href="#" class="view-more"><i class="far fa-arrow-right"></i></a>
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
                <div class="col-4">
                    <a href="#" class="item">
                        <span class="img" style="background-image: url({{ $slideImage[$i] }})"></span>
                        <span class="descr">
                            <span class="name font-size-16"><b>{{ $slideTitle[$i] }}</b></span>
                            <span class="text font-size-16">{{ $slideText[$i] }}</span>
                        </span>
                    </a>
                </div>
            @endfor
        </div>
    </div>
</section>
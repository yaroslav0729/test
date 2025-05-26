@php
    $exploreTitle = "";
    $exploreText = "";
    $donateLink = "";
    $projImg1 = "";
    $projImg2 = "";
    $projText1 = "";
    $projText2 = "";
    
    if (isset($parameters['exp_title'])) {
        $exploreTitle = $parameters['exp_title'];    
    }

    if (isset($parameters['exp_text'])) {
        $exploreText = $parameters['exp_text'];    
    }

    if (isset($parameters['donate_link'])) {
        $donateLink = $parameters['donate_link'];    
    }

    if (isset($parameters['proj_img1'])) {
        $projImg1 = $parameters['proj_img1'];    
    }

    if (isset($parameters['proj_img2'])) {
        $projImg2 = $parameters['proj_img2'];    
    }

    if (isset($parameters['proj_text1'])) {
        $projText1 = $parameters['proj_text1'];    
    }

    if (isset($parameters['proj_text2'])) {
        $projText2 = $parameters['proj_text2'];    
    }

@endphp

<section class="explore-past-missions bg-red">
    <div class="row">
        <div class="col-12">
            <p class="font-size-30 text-white mb-3"><b>{{ $exploreTitle }}</b></p>
            <p class="font-size-16 text-white mb-5">
                {{ $exploreText }}
            </p>
            <div class="pt-0">
                <a href="{{ $donateLink }}" class="btn btn-outline-primary border-white">Donate now</a>
            </div>
        </div>
        <div class="col-12" swiper-wrapper="explore_past">
            <div class="pt-5"></div>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="item">
                            <img src="{{ $projImg1 }}" alt="">
                            <span class="place"><span class="text-dark"><i class="fal fa-map-marker-alt"></i> 
                                @empty($projText1)
                                    Turkey
                                @else
                                    {{ $projText1 }}
                                @endempty
                            </span>
                        </span>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <img src="{{ $projImg2 }}" alt="">
                            <span class="place"><span class="text-dark"><i class="fal fa-map-marker-alt"></i> {{ $projText2 }}</span></span>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</section>
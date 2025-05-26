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
        <div class="col-12 col-lg-4 pr-5">
            <p class="font-size-40 text-white mb-3 line-height-13">
                @empty($exploreTitle)
                <b>Explore past Missions</b>
                @else
                <b>{{ $exploreTitle }}</b>
                @endempty
            </p>
            <p class="font-size-16 text-white mb-5">
                @empty($exploreText)
                    The first Mission Possible deployment was to Mafia Island in Tanzania in 2009. Since then, annual deployments have delivered aid and support thousands of people in some of the country’s poorest communities.
                @else
                    {{ $exploreText }}
                @endempty
            </p>
            <div class="pt-0">
                <a href="{{ $donateLink }}" class="btn btn-outline-primary border-white">Donate now</a>
            </div>
        </div>
        <div class="col-12 col-lg-8">
            <div class="pt-5 pb-3 d-block d-lg-none"></div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="item mt-n4">
                        @empty($projImg1)
                        <img src="img/content/explore-past-missions1.jpg" alt="">
                        @else
                        <img src="{{ $projImg1 }}" alt="">
                        @endempty

                        <span class="place">
                            <span class="text-dark"><i class="fal fa-map-marker-alt"></i> 
                            @empty($projText1)
                                Turkey
                            @else
                                {{ $projText1 }}
                            @endempty
                            </span>
                        </span>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="item mt-5">
                        @empty($projImg2)
                        <img src="img/content/explore-past-missions2.jpg" alt="">
                        @else
                        <img src="{{ $projImg2 }}" alt="">
                        @endempty
                        <span class="place">
                            <span class="text-dark"><i class="fal fa-map-marker-alt"></i> 
                                @empty($projText2)
                                    kashmir, India
                                @else
                                    {{ $projText2 }}
                                @endempty
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@php

    $experienceVideo = "";
    $expTitle = "";
    $expText2 = "";
    $expDate1 = "";
    $expText3 = "";
    $expQuote = "";

    if (isset($parameters['exp_video'])) {
        $experienceVideo = $parameters['exp_video'];    
    }

    if (isset($parameters['exper_title'])) {
        $expTitle = $parameters['exper_title'];    
    }

    if (isset($parameters['exp_text2'])) {
        $expText2 = $parameters['exp_text2'];    
    }

    if (isset($parameters['exp_date1'])) {
        $expDate1 = $parameters['exp_date1'];    
    }

    if (isset($parameters['exp_text3'])) {
        $expText3 = $parameters['exp_text3'];    
    }

    if (isset($parameters['exp_quote'])) {
        $expQuote = $parameters['exp_quote'];    
    }

@endphp

<section class="experience-lifetime">
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="img-video videoWrapper" style="">
                <iframe width="1280" height="720"
                        @empty($experienceVideo)
                            src="https://www.youtube.com/embed/YMxBCe1axQ8"
                        @else
                            src="https://www.youtube.com/embed/{{ $experienceVideo }}" 
                        @endempty

                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
            </div>
        </div>
        <div class="col-12 col-md-6 pl-5 pt-3 pb-3">
            <p class="font-size-40 mb-0"><b>{{ $expTitle }}</b></p>
            <p class="font-size-16 mb-5 text-danger">{{ $expText2 }}</p>
            <p class="font-size-45 mb-1 text-danger">{{ $expDate1 }}</p>
            <p class="font-size-20 mb-3"><b>{{ $expText3 }}</b></p>
            <div class="pr-0 pr-md-5">
                <p class="font-size-16 mb-5">
                    {{ $expQuote }}
                </p>
            </div>
        </div>
    </div>
</section>
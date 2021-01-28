@php

    $longtermLink = "";
    $emergencyLink = "";
    $volunteeringLink = "";
    $sadiqahLink = "";

    if (isset($parameters['our_work_longterm_link'])) {
        $longtermLink = $parameters['our_work_longterm_link'];
    }

    if (isset($parameters['our_work_emergency_link'])) {
        $emergencyLink = $parameters['our_work_emergency_link'];
    }

    if (isset($parameters['our_work_volunteering_link'])) {
        $volunteeringLink = $parameters['our_work_volunteering_link'];
    }

    if (isset($parameters['our_work_sadiqah_link'])) {
        $sadiqahLink = $parameters['our_work_sadiqah_link'];
    }
    
@endphp

<section class="our-work">
    <div class="wrap">
        <div class="mb-4">
            <a href="#" class="text-underline text-dark view-more"><b>OUR WORK</b></a>
        </div>
        <div class="row">
            <div class="col-6 col-lg-3">
                <a href="{{ $longtermLink }}">
                    <span style="background-image: url(img/ico-leaf.svg)"></span>
                    <p>Longterm Projects</p>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="{{ $emergencyLink }}">
                    <span style="background-image: url(img/ico-alert.svg)"></span>
                    <p>Emergency Relief</p>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="{{ $volunteeringLink }}">
                    <span style="background-image: url(img/ico-motivation.svg)"></span>
                    <p>Volunteering</p>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="{{ $sadiqahLink }}">
                    <span style="background-image: url(img/ico-Saadiqah.svg)"></span>
                    <p>Sadiqah</p>
                </a>
            </div>
        </div>
    </div>
</section>
@php

    $mainTitle = "";

    if (isset($parameters['main_title'])) {
        $mainTitle = $parameters['main_title'];    
    }

    $afterTitleText = "";

    if (isset($parameters['after_text'])) {
        $afterTitleText = $parameters['after_text'];    
    }

    $donateToProjTitle = "";

    if (isset($parameters['donate_to_title'])) {
        $donateToProjTitle = $parameters['donate_to_title'];    
    }

    $donateToProjText = "";

    if (isset($parameters['donate_to_text'])) {
        $donateToProjText = $parameters['donate_to_text'];    
    }

    $sProjects = \App\Models\Project::getSingleProjects();
    $mProjects = \App\Models\Project::getMonthlyProjects();
    $aProjects = \App\Models\Project::getAppealProjects();

@endphp


<section class="donate-today">
    <div class="wrap">
        <div class="title">
            <div class="row align-items-center">
                <div class="col-6">
                    @empty($mainTitle)
                        <p class="font-size-60"><b>Donate today</b></p>
                    @else
                        <p class="font-size-60"><b>{{ $mainTitle }}</b></p>
                    @endempty
                </div>
                <div class="col-6 text-right">
                    <a href="#" class="text-underline text-uppercase text-dark"><b>calculate my zakat</b></a>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-6">
                    @empty($afterTitleText)
                        <p class="font-size-16">Make your donation here of which 100ch ut perspiciatis unde omnis iste natus demiour sit voluptatem.</p>
                    @else
                        <p class="font-size-16">{{ $afterTitleText }}</p>
                    @endempty
                    
                </div>
            </div>
        </div>

        @include('modules.presentation.projects_donate', [
            'parameters' => $parameters,
            'useAppeal' => true
        ])

    </div>
</section>

<section class="donate-projects-list">
    <div class="title">
        <div class="wrap">
            <div class="row">
                <div class="col-6">
                    @empty($donateToProjTitle)
                        <p class="font-size-30"><b>Donate to a project too?</b></p>
                    @else
                        <p class="font-size-30"><b>{{ $donateToProjTitle }}</b></p>
                    @endempty

                    @empty($donateToProjText)
                        <p class="font-size-16">You could also join the journey to support our causes that empower those in need each month/single donation 100ch.</p>
                    @else
                        <p class="font-size-16">{{ $donateToProjText }}</p>
                    @endempty
                    

                </div>
            </div>
        </div>
    </div>

    <div class="filter_projects_single" filter-projects>
        @include('modules.presentation.projects_tiles', ['projects' => $sProjects])
    </div>

    <div class="filter_projects_monthly d-none" filter-projects>
        @include('modules.presentation.projects_tiles', ['projects' => $mProjects])
    </div>

    <div class="filter_projects_appeal d-none" filter-projects>
        @include('modules.presentation.projects_tiles', ['projects' => $aProjects])
    </div>

</section>

@include('modules.presentation.donation_page_cart')

<section class="other-way-give">
    <div class="wrap">
        <div class="mb-5 text-center">
            <p class="font-size-30"><b>Other ways to give:</b></p>
        </div>
        <div class="row">
            <div class="col-3">
                <a href="#">
                    <span style="background-image: url(img/ico-telephone.png)"></span>
                    <p><b>Call Us</b></p>
                    <i href="#">MORE DETAILS</i>
                </a>
            </div>
            <div class="col-3">
                <a href="#">
                    <span style="background-image: url(img/ico-bank-transfer.png)"></span>
                    <p><b>Bank Transfer</b></p>
                    <i href="#">MORE DETAILS</i>
                </a>
            </div>
            <div class="col-3">
                <a href="#">
                    <span style="background-image: url(img/ico-Paym.png)"></span>
                    <p><b>By Mobile</b></p>
                    <i href="#">MORE DETAILS</i>
                </a>
            </div>
            <div class="col-3">
                <a href="#">
                    <span style="background-image: url(img/ico-Paypal.png)"></span>
                    <p><b>Paypal</b></p>
                    <i href="#">MORE DETAILS</i>
                </a>
            </div>
        </div>
    </div>
</section>

@include('templates.presentation.parts.add_to_cart_popup')

<div class="pt-5"></div>


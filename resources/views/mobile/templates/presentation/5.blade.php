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

@endphp

<section class="donate-today">
    <div class="wrap">
        <div class="body">

            @include('modules.presentation.donate_module', [
                'parameters' => $parameters,
                'useAppeal' => true
            ])

        </div>

    </div>
</section>


<section class="donate-projects-list">
    <div class="title text-center">
        <p><b>{{ $donateToProjTitle }}</b></p>
    </div>

    {{-- Single donate projects --}}
    @php
        $sProjects = \App\Models\Project::getSingleProjects();
    @endphp

    <div class="row filter_projects_single" filter-projects>
        @include('modules.presentation.projects_tiles', ['projects' => $sProjects])
    </div>

    {{-- Monthly donate projects --}}
    @php
        $mProjects = \App\Models\Project::getMonthlyProjects();
    @endphp

    <div class="row  filter_projects_monthly" filter-projects>
        @include('modules.presentation.projects_tiles', ['projects' => $mProjects])
    </div>

    {{-- Appeal donate projects --}}
    @php
        $aProjects = \App\Models\Project::getAppealProjects();
    @endphp

    <div class="row filter_projects_appeal" filter-projects>
        @include('modules.presentation.projects_tiles', ['projects' => $aProjects])
    </div>

</section>

@include('modules.presentation.donation_page_cart')

<section class="other-way-give-mobile">
    <div class="wrap">
        <a href="tel:01214465682" class="phone"><i class="fal fa-phone-alt"></i> HOTLINE &nbsp;&nbsp;&nbsp;0121 446 5682 </a>
    </div>


    <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <span class="collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    BANK TRANSFER
                    <i class="far fa-chevron-down"></i>
                </span>
            </div>
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTwo">
                <span class="collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    BY MOBILE
                    <i class="far fa-chevron-down"></i>
                </span>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingThree">
                <span class="collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    PAYPAL
                    <i class="far fa-chevron-down"></i>
                </span>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                </div>
            </div>
        </div>
    </div>

</section>


<div class="added-to-cart-snackbar" style="display: none">
    <i class="fal fa-shopping-cart"></i>
    <div class="price">£250</div>
    <span>This Monthly Donation has been added to your cart!</span>
</div>


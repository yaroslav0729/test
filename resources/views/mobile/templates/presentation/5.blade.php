@php

$mainTitle = '';

if (isset($parameters['main_title'])) {
    $mainTitle = $parameters['main_title'];
}

$afterTitleText = '';

if (isset($parameters['after_text'])) {
    $afterTitleText = $parameters['after_text'];
}

$donateToProjTitle = '';

if (isset($parameters['donate_to_title'])) {
    $donateToProjTitle = $parameters['donate_to_title'];
}

$donateToProjText = '';

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

    <div class="row filter_projects_single filter-projects" filter-projects>
        @include('modules.presentation.projects_tiles', ['projects' => $sProjects])
    </div>
    <div class="fake-popup-wrapper">
        <div class="fake-popup"></div>
    </div>

    {{-- Monthly donate projects --}}
    @php
        $mProjects = \App\Models\Project::getMonthlyProjects();
    @endphp

    <div class="row  filter_projects_monthly filter-projects" filter-projects>
        @include('modules.presentation.projects_tiles', ['projects' => $mProjects])
    </div>

    {{-- Appeal donate projects --}}
    @php
        $aProjects = \App\Models\Project::getAppealProjects();
    @endphp

    <div class="row filter_projects_appeal filter-projects" filter-projects>
        @include('modules.presentation.projects_tiles', ['projects' => $aProjects])
    </div>

</section>

@include('modules.presentation.donation_page_cart')

<section class="other-way-give-mobile">
    <h3 class="title">
        Other ways to give
    </h3>
    <div class="wrap">
        <a href="tel:01214465682" class="phone"><i class="fal fa-phone-alt"></i> HOTLINE &nbsp;&nbsp;&nbsp;<b>0121 446
                5682</b> </a>
    </div>


    <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <span class="collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false"
                    aria-controls="collapseOne">
                    BANK TRANSFER
                    <i class="far fa-chevron-down"></i>
                </span>
            </div>
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <p>You can put money directly into our bank account</p>
                    <br>
                    <p>Name: Islamic Help</p>
                    <p>Bank: HSBC</p>
                    <p>Account No:41687425</p>
                    <p>Sort Code: 40-42-12</p>
                    <br>


                    <p>If you are in a country other than the UK, you can go into any bank in the world and quote the
                    </p>
                    <p>following International Bank Account</p>
                    <br>
                    <p>Number (IBAN) and Branch Identifier Code (BIC)</p>
                    <br>
                    <p>IBAN: GB12HBUK40421241687425</p>
                    <p>BIC: HBUKGB4155G</p>
                </div>
            </div>
        </div>
{{--        <div class="card">--}}
{{--            <div class="card-header" id="headingTwo">--}}
{{--                <span class="collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"--}}
{{--                    aria-controls="collapseTwo">--}}
{{--                    BY MOBILE--}}
{{--                    <i class="far fa-chevron-down"></i>--}}
{{--                </span>--}}
{{--            </div>--}}
{{--            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">--}}
{{--                <div class="card-body">--}}
{{--                    <p>Donate simply using our mobile number 07960715263 and your mobile banking app.</p>--}}
{{--                    <p>This is a safe and secure way to pay, where you don’t need to share your banking details with--}}
{{--                        anyone. To find out more about how to use Paym .please&nbsp;<strong><a--}}
{{--                                href="http://www.paym.co.uk/how-does-it-work/">click here</a></strong></p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="card">
            <div class="card-header" id="headingThree">
                <span class="collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                    aria-controls="collapseThree">
                    PAYPAL
                    <i class="far fa-chevron-down"></i>
                </span>
            </div>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
                    <p>Pay online with PayPal and skip putting in any financial information.</p>
                </div>
            </div>
        </div>
    </div>
    @include('parts.footer')
</section>


<div class="added-to-cart-snackbar" style="display: none">
    <i class="fal fa-shopping-cart"></i>
    <div class="price">£250</div>
    <span>This Monthly Donation has been added to your cart!</span>
</div>

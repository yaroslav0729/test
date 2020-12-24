@php

    $mainTitle = "";
    $startLink = "";
    $colTitle1 = "";
    $colText1 = "";
    $colTitle2 = "";
    $colText2 = "";
    $colTitle3 = "";
    $colText3 = "";

    if (isset($parameters['main_title'])) {
        $mainTitle = $parameters['main_title'];
        $mainTitle = str_replace('|', '<br>', $mainTitle);
    }

    if (isset($parameters['start_link'])) {
        $startLink = $parameters['start_link'];    
    }

    if (isset($parameters['col_title1'])) {
        $colTitle1 = $parameters['col_title1'];    
    }

    if (isset($parameters['col_text1'])) {
        $colText1 = $parameters['col_text1'];    
    }

    if (isset($parameters['col_title1'])) {
        $colTitle2 = $parameters['col_title1'];    
    }

    if (isset($parameters['col_text2'])) {
        $colText2 = $parameters['col_text2'];    
    }

    if (isset($parameters['col_title3'])) {
        $colTitle3 = $parameters['col_title3'];    
    }

    if (isset($parameters['col_text3'])) {
        $colText3 = $parameters['col_text3'];    
    }

@endphp


<div class="pt-5 bp-5"></div>
<section class="head-Volunteer">
    <!--step 1-->

    @empty($mainTitle)
    <h1>Great! You've taken<br>the first step in doing<br>good, let's get<br>cracking then.</h1>
    @else
    <h1>{!! $mainTitle !!}</h1>
    @endempty
    
    <a href="{{ $startLink }}"><button class="btn btn-outline-primary btn-lg btn-black">Start</button></a>

</section>

<section class="how-does-work with-lines">
    <div class="title">
        <p>How do I do this? </p>
        <span>Find the mission you love</span>
    </div>
    <div class="row">
        <div class="col pr-0 pr-md-5">
            <div class="item">
                <img src="img/ico-apply-online.svg" alt="">
                <div class="num">01</div>
                <div>{{ $colTitle1 }}</div>
                <p>{{ $colText1 }}</p>
            </div>
        </div>
        <div class="col pl-0 pr-0 pl-md-5  pr-0 pr-md-5">
            <div class="item">
                <img src="img/ico-email.svg" alt="">
                <div class="num">02</div>
                <div>{{ $colTitle2 }}</div>
                <p>{{ $colText2 }}</p>
            </div>
        </div>
        <div class="col">
            <div class="item pl-0 pl-md-5">
                <img src="img/ico-post.svg" alt="">
                <div class="num">03</div>
                <div>{{ $colTitle3 }}</div>
                <p>{{ $colText3 }}</p>
            </div>
        </div>
    </div>
</section>

<section class="discover-more bg-danger-light">
    <div class="wrap">
        <div class="title">
            <div class="row">
                <div class="col-7">
                    <b class="font-size-30 mr-4 text-uppercase">make a difference today</b>
                </div>
                <div class="col-5 text-right">
                    <a href="#" class="text-uppercase text-underline"><b>visit newsroom</b> <i class="moon-icons-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <div class="current-projects-list">
            <div class="row">
                <div class="col-4">
                    <a href="#" class="item">
                        <span class="img" style="background-image: url(img/content/discover-more-1.jpg)"></span>
                        <span class="descr">
                    <span class="name font-size-16">EVENT</span>
                    <span class="text font-size-16"><b>Critical campaign title, 60 char lorem sit amet, demis.</b></span>
                </span>
                    </a>
                </div>
                <div class="col-4">
                    <a href="#" class="item">
                        <span class="img" style="background-image: url(img/content/discover-more-2.jpg)"></span>
                        <span class="descr">
                    <span class="name font-size-16">PROJECT</span>
                    <span class="text font-size-16"><b>Critical campaign title, 60 char lorem sit amet, demis.</b></span>
                </span>
                    </a>
                </div>
                <div class="col-4">
                    <a href="#" class="item">
                        <span class="img" style="background-image: url(img/content/discover-more-3.jpg)"></span>
                        <span class="descr">
                    <span class="name font-size-16">ARTICLE</span>
                    <span class="text font-size-16"><b>Critical campaign title, 60 char lorem sit amet, demis.</b></span>
                </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

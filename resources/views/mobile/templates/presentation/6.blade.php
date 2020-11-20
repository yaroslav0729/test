@php

    $mainHtml = "";
    $importantInfoTitle = "";
    $importantInfo = "";

    if (isset($parameters['main_html'])) {
        $mainHtml = $parameters['main_html'];    
    }

    if (isset($parameters['important_title'])) {
        $importantInfoTitle = $parameters['important_title'];    
    }

    if (isset($parameters['important_text'])) {
        $importantInfo = $parameters['important_text'];    
    }

@endphp

<div class="pt-4"></div>
<section class="donate-today">
    <div class="wrap">
        <div class="title text-left pr-5">
            <p><b>{{ $pageInstance->name }}</b></p>
            <i class="far fa-arrow-down"></i>
        </div>

        <div class="body">
            <div class="media">
                <img src="img/content/donate-today-1.jpg" alt="" class="w-100">
            </div>

            <div class="mb-5 font-size-18">Your subtitle/copy can go here, max of 100ch ut perspi unde omnis iste natus demiour sit voluptatem, abilloum inventore.</div>
            <div class="black-line"></div>
            <div class="pt-5"></div>

            <div class="donate-today-sheet">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-link color-info active"  data-toggle="tab" href="#nav-1" role="tab" aria-selected="true">Single</a>
                        <a class="nav-link color-info"  data-toggle="tab" href="#nav-2" role="tab"  aria-selected="false">Monthly</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-1" role="tabpanel" >
                        <form action="/">
                            <label class="item">
                                <input type="radio" name="r1">
                                <span class="d-flex align-items-center">
                                            <span><span>£<b>30</b></span></span>
                                            <span>Give a child food & warmth</span>
                                        </span>
                            </label>
                            <label class="item">
                                <input type="radio" name="r1">
                                <span class="d-flex align-items-center">
                                            <span><span>£<b>50</b></span></span>
                                            <span>Winter Foodpack for a family</span>
                                        </span>
                            </label>
                            <label class="item">
                                <input type="radio" name="r1">
                                <span class="d-flex align-items-center">
                                            <span><span>£<b>100</b></span></span>
                                            <span>Shelter and food for a family</span>
                                        </span>
                            </label>
                            <div class="pt-3"></div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="£  Enter amount">
                            </div>
                            <div class="form-group">
                                <select class="form-control">
                                    <option value="1">General Charity</option>
                                    <option value="1">General Charity 2</option>
                                </select>
                            </div>
                            <div class="pt-3"></div>
                            <div class="text-center">
                                <button class="btn btn-info border-white btn-submit w-100">Donate</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="nav-2" role="tabpanel" >
                        <form action="/">
                            <label class="item active-color-info">
                                <input type="radio" name="r1">
                                <span class="d-flex align-items-center">
                                            <span><span>£<b>30</b></span></span>
                                            <span>Give a child food & warmth</span>
                                        </span>
                            </label>
                            <label class="item active-color-info">
                                <input type="radio" name="r1">
                                <span class="d-flex align-items-center">
                                            <span><span>£<b>50</b></span></span>
                                            <span>Winter Foodpack for a family</span>
                                        </span>
                            </label>
                            <label class="item active-color-info">
                                <input type="radio" name="r1">
                                <span class="d-flex align-items-center">
                                            <span><span>£<b>100</b></span></span>
                                            <span>Shelter and food for a family</span>
                                        </span>
                            </label>
                            <div class="pt-3"></div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="£  Enter amount">
                            </div>
                            <div class="form-group">
                                <select class="form-control">
                                    <option value="1">General Charity</option>
                                    <option value="1">General Charity 2</option>
                                </select>
                            </div>
                            <div class="pt-3"></div>
                            <div class="text-center">
                                <button class="btn btn-info border-white btn-submit w-100">Donate</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="blog-article-body">
    <div class="wrap">
        <div class="body">
            {!! $mainHtml !!}
        </div>
    </div>
</section>

<div class="pt-5"></div>

<section class="whats-happened-far">
    <p style="padding-left: 30px;" class="font-size-12 mb-4"><b>ISLAMIC HELP'S RESULTS</b></p>
    <div class="black-line"></div>
    <div class="body">
        <div class="tl">What's happened so far.</div>
        <div class="text bg-info">
            <p>180 Characters perspiciais und omnis iste natus error sit volup tatem accusantium dis doloremque laudantium, totam annum rem aperiam, eaque ipsa quae ab illomsi inventore veritatis.</p>
        </div>
        <img src="img/content/project-2.jpg" alt="" class="w-100">
        <div class="help-info-swiper">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <span>8k</span>
                        <span>People helped</span>
                    </div>
                    <div class="swiper-slide">
                        <span>36</span>
                        <span>Countries</span>
                    </div>
                    <div class="swiper-slide">
                        <span>1'407</span>
                        <span>Volunteers this year</span>
                    </div>
                </div>
                <div class="swiper-button-next"><i class="far fa-arrow-right"></i></div>
                <div class="swiper-button-prev"><i class="far fa-arrow-left"></i></div>
            </div>

            <script>
                var swiper = new Swiper('.help-info-swiper .swiper-container', {
                    navigation: {
                        nextEl: '.help-info-swiper .swiper-button-next',
                        prevEl: '.help-info-swiper .swiper-button-prev',
                    },
                });
            </script>
        </div>
    </div>
</section>


<section class="donate-today-card">
    <div class="wrap">
        <div class="title">
            <span>We still need your support.</span>
        </div>

        <div class="list donate-today-card-swiper">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="item">
                            <div>£<b>30</b></div>
                            This donation<br>
                            could lorem analai<br>
                            dolor annum 50ch.
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item active-color-info">
                            <div>£<b>60</b></div>
                            This donation<br>
                            could lorem analai<br>
                            dolor annum 50ch.
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item active-color-danger">
                            <div>£<b>100</b></div>
                            This donation<br>
                            could lorem analai<br>
                            dolor annum 50ch.
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

        {{-- <script>
            var swiper = new Swiper('.donate-today-card-swiper .swiper-container', {
                pagination: {
                    el: '.donate-today-card-swiper .swiper-pagination'
                }
            });
        </script> --}}

    </div>
</section>


<section class="join-cause">
    <div class="wrap">
        <div class="title mb-2">
        <p class="font-size-16 text-uppercase"><b>{{ $importantInfoTitle }}</b></p>
        </div>
        <p class="font-size-16">
            {{ $importantInfo }}
        </p>
    </div>
</section>

@include('modules.presentation.related_pages', [
    'parameters' => $parameters
])

@include('modules.presentation.join_the_cause_subscribe')

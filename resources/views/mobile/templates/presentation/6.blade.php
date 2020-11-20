@php

    $mainHtml = "";

    if (isset($parameters['main_html'])) {
        $mainHtml = $parameters['main_html'];    
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

@include('modules.presentation.what_happens_so_far')

@include('modules.presentation.we_still_need_support')

@include('modules.presentation.important_information')

@include('modules.presentation.related_pages')

@include('modules.presentation.join_the_cause_subscribe')

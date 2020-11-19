@php

    $mainHtml = "";

    if (isset($parameters['main_html'])) {
        $mainHtml = $parameters['main_html'];    
    }

@endphp

<div class="pt-4"></div>
<div class="pt-5"></div>

<section class="donate-today blue-gradient">
    <div class="wrap">
        <div class="title mb-5">
            <p class="font-size-40"><b>{{ $pageInstance->name }}</b></p>
            <i class="far fa-arrow-down"></i>
        </div>
        <div class="pt-5"></div>

        <div class="body">
            <div class="row gutter-0">
                <div class="col-6">
                    <div class="media">
                        <img src="img/content/project-1.jpg" alt="" class="w-100">
                    </div>
                </div>
                <div class="col-6">
                    <div class="donate-today-sheet">

                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-link active color-info"  data-toggle="tab" href="#nav-1" role="tab" aria-selected="true">Single Donation</a>
                                <a class="nav-link color-info"  data-toggle="tab" href="#nav-2" role="tab"  aria-selected="false">Monthly Donation</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-1" role="tabpanel" >
                                <form action="/">
                                    <label class="item active-color-info">
                                        <input type="radio" name="r1">
                                        <span class="d-flex align-items-center">
                                            <span><span>£<b>30</b></span><span>JUST ONCE</span></span>
                                            <span>This donation could give a child a food and a blanket, to keep them warm this winter 90ch.</span>
                                        </span>
                                    </label>
                                    <label class="item active-color-info">
                                        <input type="radio" name="r1">
                                        <span class="d-flex align-items-center">
                                            <span><span>£<b>50</b></span><span>JUST ONCE</span></span>
                                            <span>This donation could give a child a food and a blanket, to keep them warm this winter 90ch.</span>
                                        </span>
                                    </label>
                                    <label class="item active-color-info">
                                        <input type="radio" name="r1">
                                        <span class="d-flex align-items-center">
                                            <span><span>£<b>100</b></span><span>JUST ONCE</span></span>
                                            <span>This donation could give a child a food and a blanket, to keep them warm this winter 90ch.</span>
                                        </span>
                                    </label>
                                    <div class="pt-3"></div>
                                    <div class="row gutter-5">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <select class="form-control">
                                                    <option value="1">General Charity</option>
                                                    <option value="1">General Charity 2</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="£  Enter amount">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <select class="form-control">
                                                    <option value="1">GPB</option>
                                                    <option value="2">USD</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pt-3"></div>
                                    <div class="text-center">
                                        <button class="btn btn-info border-white btn-submit">Donate</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="nav-2" role="tabpanel" >
                                <form action="/">
                                    <label class="item active-color-info">
                                        <input type="radio" name="r1">
                                        <span class="d-flex align-items-center">
                                            <span><span>£<b>30</b></span><span>JUST ONCE</span></span>
                                            <span>This donation could give a child a food and a blanket, to keep them warm this winter 90ch.</span>
                                        </span>
                                    </label>
                                    <label class="item active-color-info">
                                        <input type="radio" name="r1">
                                        <span class="d-flex align-items-center">
                                            <span><span>£<b>50</b></span><span>JUST ONCE</span></span>
                                            <span>This donation could give a child a food and a blanket, to keep them warm this winter 90ch.</span>
                                        </span>
                                    </label>
                                    <label class="item active-color-info">
                                        <input type="radio" name="r1">
                                        <span class="d-flex align-items-center">
                                            <span><span>£<b>100</b></span><span>JUST ONCE</span></span>
                                            <span>This donation could give a child a food and a blanket, to keep them warm this winter 90ch.</span>
                                        </span>
                                    </label>
                                    <div class="pt-3"></div>
                                    <div class="row gutter-5">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <select class="form-control">
                                                    <option value="1">General Charity</option>
                                                    <option value="1">General Charity 2</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="£  Enter amount">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <select class="form-control">
                                                    <option value="1">GPB</option>
                                                    <option value="2">USD</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pt-3"></div>
                                    <div class="text-center">
                                        <button class="btn btn-info border-white btn-submit">Donate</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="descr"><div>Your subtitle/copy can go here, max of 100ch ut perspi unde omnis iste natus demiour sit voluptatem, abilloum inventore.</div></div>
            </div>
        </div>
    </div>
</section>

<div class="pt-5"></div>
<div class="pt-5"></div>

<section class="blog-article-body">
    <div class="wrap">
        <div class="body">
            {!! $mainHtml !!}
        </div>
    </div>
</section>

<div class="pt-5"></div>

@include('modules.presentation.share_this')

<section class="whats-happened-far">
    <p style="padding-left: 90px;" class="font-size-12 mb-4"><b>ISLAMIC HELP'S RESULTS</b></p>
    <div class="black-line"></div>
    <div class="body">
        <div class="row gutter-0">
            <div class="col-7" style="z-index: 2">
                <div class="tl">What's happened so far.</div>
                <div class="text bg-info">
                    <p>180 Characters perspiciais und omnis iste natus error sit volup tatem accusantium dis doloremque laudantium, totam annum rem aperiam, eaque ipsa quae ab illomsi inventore veritatis.</p>
                    <div class="info">
                        <div class="bg bg-danger-light"></div>
                        <div class="rectangle bg-danger"></div>
                        <div class="help-info">
                            <div>
                                <span>8k</span>
                                <span>People helped</span>
                            </div>
                            <div>
                                <span>36</span>
                                <span>Countries</span>
                            </div>
                            <div>
                                <span>1'407</span>
                                <span>Volunteers this year</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <img src="img/content/project-2.jpg" alt="">
            </div>
        </div>
    </div>
</section>


<section class="donate-today-card">
    <div class="wrap">
        <div class="title">
            <span>We still need your support.</span>
        </div>
        <div class="list d-flex justify-content-center">
            <div class="item">
                <div>£<b>30</b></div>
                This donation<br>
                could lorem analai<br>
                dolor annum 50ch.
            </div>
            <div class="item active-color-info">
                <div>£<b>60</b></div>
                This donation<br>
                could lorem analai<br>
                dolor annum 50ch.
            </div>
            <div class="item active-color-danger">
                <div>£<b>100</b></div>
                This donation<br>
                could lorem analai<br>
                dolor annum 50ch.
            </div>
        </div>
    </div>
</section>


<section class="join-cause">
    <div class="wrap">
        <div class="title mb-5">
            <p class="font-size-30"><b>Important information / please note CTA</b></p>
        </div>
        <p class="font-size-20">
            Perspiciais und omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicab. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed consequuntur magni dolores eos qui rati voluptate sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.
        </p>
    </div>
</section>

@include('modules.presentation.related_pages', [
    'parameters' => $parameters
])

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
<div class="pt-5"></div>

<section class="donate-today blue-gradient">
    <div class="wrap">
        <div class="title mb-5">
            <p class="font-size-40"><b>{{ $pageInstance->name }}</b></p>
            <i class="far fa-arrow-down"></i>
        </div>
        <div class="pt-5"></div>

        @include('modules.presentation.projects_donate', ['parameters' => $parameters])

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
            <p class="font-size-30"><b>{{ $importantInfoTitle }}</b></p>
        </div>
        <p class="font-size-20">
            {{ $importantInfo }}
        </p>
    </div>
</section>

@include('modules.presentation.related_pages', [
    'parameters' => $parameters
])

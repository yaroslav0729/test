@php

    $moduleTitle = "";
    $moduleText = "";

    if (isset($parameters['what_happens_title'])) {
        $moduleTitle = $parameters['what_happens_title'];    
    }

    if (isset($parameters['what_happens_text'])) {
        $moduleText = $parameters['what_happens_text'];    
    }

    $peopleHelped = "";
    $countries = "";
    $volunteers = "";

    if (isset($parameters['what_happens_people_helped'])) {
        $peopleHelped = $parameters['what_happens_people_helped'];    
    }

    if (isset($parameters['what_happens_countries'])) {
        $countries = $parameters['what_happens_countries'];    
    }

    if (isset($parameters['what_happens_volunteers'])) {
        $volunteers = $parameters['what_happens_volunteers'];    
    }

@endphp

<section class="whats-happened-far">
    <p style="padding-left: 90px;" class="font-size-12 mb-4"><b>ISLAMIC HELP'S RESULTS</b></p>
    <div class="black-line"></div>
    <div class="body">
        <div class="row gutter-0">
            <div class="col-7" style="z-index: 2">
                @empty($moduleTitle)
                <div class="tl">What's happened so far.</div>
                @else 
                <div class="tl">{{ $moduleTitle }}</div>
                @endisset

                <div class="text bg-info">
                    @empty($moduleText)
                    <p>180 Characters perspiciais und omnis iste natus error sit volup tatem accusantium dis doloremque laudantium, totam annum rem aperiam, eaque ipsa quae ab illomsi inventore veritatis.</p>
                    @else 
                    <p>{{ $moduleText }}</p>
                    @endisset
                    <div class="info">
                        <div class="bg bg-danger-light"></div>
                        <div class="rectangle bg-danger"></div>
                        <div class="help-info">
                            <div>
                                <span>{{ $peopleHelped }}k</span>
                                <span>People helped</span>
                            </div>
                            <div>
                                <span>{{ $countries }}</span>
                                <span>Countries</span>
                            </div>
                            <div>
                                <span>{{ $volunteers }}</span>
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
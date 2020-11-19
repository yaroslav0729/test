@php

    $previewText = "";
    $previewPosition = "";
    $previewImage = "";

    $eventDateText = "";
    $eventTimeText = "";
    $eventLink = "";
    $eventLinkText = "";

    $eventDetailsEntry = "";
    $eventDetailsOrganiser = "";
    $eventDetailsSpeaker = "";
    $eventDetailsContact = "";

    $mainHtml = "";

    $informationTitle ="";
    $informationText ="";

    if (isset($parameters['preview_text'])) {
        $previewText = $parameters['preview_text'];    
    }

    if (isset($parameters['preview_position'])) {
        $previewPosition = $parameters['preview_position'];    
    }

    if (isset($parameters['preview_image'])) {
        $previewImage = $parameters['preview_image'];    
    }

    if (isset($parameters['event_date_text'])) {
        $eventDateText = $parameters['event_date_text'];    
    }

    if (isset($parameters['event_time_text'])) {
        $eventTimeText = $parameters['event_time_text'];    
    }

    if (isset($parameters['event_link'])) {
        $eventLink = $parameters['event_link'];    
    }

    if (isset($parameters['event_link_text'])) {
        $eventLinkText = $parameters['event_link_text'];    
    }

    if (isset($parameters['event_details_entry'])) {
        $eventDetailsEntry = $parameters['event_details_entry'];    
    }

    if (isset($parameters['event_details_entry'])) {
        $eventDetailsEntry = $parameters['event_details_entry'];    
    }

    if (isset($parameters['event_details_organiser'])) {
        $eventDetailsOrganiser = $parameters['event_details_organiser'];    
    }

    if (isset($parameters['event_details_speaker'])) {
        $eventDetailsSpeaker = $parameters['event_details_speaker'];    
    }

    if (isset($parameters['event_details_contact'])) {
        $eventDetailsContact = $parameters['event_details_contact'];    
    }

    if (isset($parameters['main_html'])) {
        $mainHtml = $parameters['main_html'];    
    }

    if (isset($parameters['information_title'])) {
        $informationTitle = $parameters['information_title'];    
    }

    if (isset($parameters['information_text'])) {
        $informationText = $parameters['information_text'];    
    }

@endphp

<section class="event-info-head bg-light">
    <div class="wrap">
        <div class="mb-4">
            @include('templates.presentation.parts.back_btn')
        </div>

        <div class="row gutter-0 align-items-center">
            <div class="col-7">
                <div class="box">
                    <div class="text-right">
                    <span class="place"><i class="fal fa-map-marker-alt"></i> <span class="text-dark">{{ $previewPosition }}</span></span>
                    </div>
                    <h1>{{ $pageInstance->name }}</h1>
                    <p>{{ $previewText }}</p>
                    <span class="date">Oct<span>26</span></span>
                </div>
            </div>
            <div class="col-5">
            <img src="{{ $previewImage }}" alt="" class="w-100">
            </div>
        </div>
    </div>
</section>

<section class="event-info-descr">
    <div class="wrap">
        <div class="top">
            <div class="row align-items-center">
                <div class="col-6">
                    <b><i></i>{{ $eventDateText }}</b>
                    <b>{{ $eventTimeText }}</b>
                </div>
                <div class="col-6 text-right">
                    <a href="{{ $eventLink }}">{{ $eventLinkText }}</a>
                    <span><i class="fal fa-map-marker-alt"></i></span>
                </div>
            </div>
        </div>
        <div class="down">
            <div class="row gutter-10">
                <div class="col-4">
                    <div>
                        <div class="title"><b>event details</b></div>
                        <div>
                            <div><b>Event entry:</b></div>
                            <div class="text-danger"><b>{{ $eventDetailsEntry }}</b></div>
                        </div>
                        <div class="line"></div>
                        <div>
                            <div><b>Organiser:</b></div>
                            <div class="text-danger"><b>{{ $eventDetailsOrganiser }}</b></div>
                        </div>
                        <div class="line"></div>
                        <div>
                            <div><b>Speaker:</b></div>
                            <div class="text-danger"><b>{{ $eventDetailsSpeaker }}</b></div>
                        </div>
                        <div class="line"></div>
                        <div>
                            <div><b>Contact:</b></div>
                            <div class="text-danger"><b>{{ $eventDetailsContact }}</b></div>
                        </div>

                    </div>
                </div>
                <div class="col-8">
                    <div>
                        <div class="title"><b>register here</b> (Seats available)</div>
                        <div class="row align-items-center">
                            <div class="col-7"><b class="text-uppercase">Mon, 26 October 2020, 10:00 - 12:30 GMT</b></div>
                            <div class="col-5 text-right text-secondary">Sales end 27 October</div>
                        </div>
                        <div class="line"></div>
                        <div class="row align-items-center">
                            <div class="col-7">
                                <div><b>Female Seating</b></div>
                                <div>FREE</div>
                            </div>
                            <div class="col-5 text-right">
                                <input type="number" value="1" min="0" max="1000" step="1"/>
                            </div>
                        </div>
                        <div class="line"></div>
                        <div class="row align-items-center">
                            <div class="col-7">
                                <div><b>Male Seating</b></div>
                                <div>FREE</div>
                            </div>
                            <div class="col-5 text-right">
                                <input type="number" value="1" min="0" max="1000" step="1"/>
                            </div>
                        </div>
                        <div class="line"></div>
                        <div class="row align-items-center">
                            <div class="col-7">
                                <div><b>QTY: 0</b></div>
                            </div>
                            <div class="col-5 text-right"><a href="#" class="btn btn-secondary">Register</a></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="blog-article-body">
    <div class="wrap">
        <div class="body">
            <h2>{{ $informationTitle }}</h2>
            {!! $mainHtml !!}
        </div>
    </div>
</section>

@include('modules.presentation.share_this')

<div class="pt-5"></div>


<section class="join-cause">
    <div class="wrap">
        <div class="title mb-5">
        <p class="font-size-30"><b>{{ $informationTitle }}</b></p>
        </div>
        <p class="font-size-20">
            {{ $informationText }}
        </p>
    </div>
</section>

<section class="discover-more">
    <div class="wrap">
        <div class="title">
            <div class="row">
                <div class="col-7">
                    <b class="font-size-30 mr-4 text-uppercase">Related topics</b>
                </div>
                <div class="col-5 text-right">
                    <a href="#" class="text-uppercase text-underline"><b>visit newsroom</b> <i class="far fa-arrow-right"></i></a>
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

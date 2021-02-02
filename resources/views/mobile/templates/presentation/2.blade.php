@php

    $eventDescription = "";
    $previewPosition = "";
    $eventTypeParticipate = "";

    $eventStartDate = "";
    $eventEndDate = "";
    $eventStartTime = "";
    $eventEndTime = "";
    $eventEndSaleDate = "";

    $eventEntryPrice = "";
    $eventDetailsOrganiser = "";
    $eventDetailsSpeaker = "";
    $eventDetailsContact = "";

    $informationTitle = "";
    $informationText = "";

    $informationTextMobile = "";

    $eventbriteCode = "";

    if (isset($parameters['event_description'])) {
        $eventDescription = $parameters['event_description'];
    }

    if (isset($parameters['preview_position'])) {
        $previewPosition = $parameters['preview_position'];
    }

    if (isset($parameters['event_type_participate'])) {
        $eventTypeParticipate = $parameters['event_type_participate'];
    }

    if (isset($parameters['event_start_date'])) {
        $eventStartDate = $parameters['event_start_date'];
    }

    if (isset($parameters['event_end_date'])) {
        $eventEndDate = $parameters['event_end_date'];
    }

    if (isset($parameters['event_start_time'])) {
        $eventStartTime = $parameters['event_start_time'];
    }

    if (isset($parameters['event_end_time'])) {
        $eventEndTime = $parameters['event_end_time'];
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

    if (isset($parameters['event_entry_price'])) {
        $eventEntryPrice = $parameters['event_entry_price'];
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

    if (isset($parameters['information_title'])) {
        $informationTitle = $parameters['information_title'];
    }

    if (isset($parameters['information_text'])) {
        $informationText = $parameters['information_text'];
    }

    if (isset($parameters['information_text_mobile'])) {
        $informationTextMobile = $parameters['information_text_mobile'];
    }

    if (isset($parameters['eventbrite_code'])) {
        $eventbriteCode = $parameters['eventbrite_code'];
    }

    $event = $pageInstance->page()->first()->event()->first();

@endphp

<section class="event-info-head">
    <div class="mb-2">
        @include('templates.presentation.parts.back_btn')
    </div>
    <div class="line">
        <span class="date">{{ $event->start_date->format('M') }}<span>{{ $event->start_date->format('d') }}</span></span>
    </div>
    <div class="img" style="background-image: url({{ $pageInstance->preview_img }})"></div>
    <div class="box">
        <span class="place"><i class="fal fa-map-marker-alt"></i> <span class="text-dark">{{ $event->location }}</span></span>
        <h1>{{ $event->name }}</h1>
        <p>{!! $eventDescription !!}</p>

    </div>
</section>

<section class="event-info-descr">
    <div class="wrap">

        @if((int)$eventTypeParticipate === \App\Models\Event::EVENT_ONLINE)
            <div class="top pb-5 m-0">
                <div>
                    <b><i></i>{{ $event->start_date->format('l jS, F Y') }}</b>
                </div>
            </div>
            <div class="center">
                <a href="#" class="webinar"><i></i>ONLINE WEBINAR</a>
            </div>
        @else
            <div class="top pb-5">
                <div>
                    <b><i></i>{{ $event->start_date->format('l jS, F Y') }}</b>
                    <b><i class="clock mt-2"></i>
                        {{ \Carbon\Carbon::parse($event->start_time)->format('h:ia') }}
                        @isset($event->end_time)
                            - {{ \Carbon\Carbon::parse($event->end_time)->format('h:ia') }}
                        @endisset
                    </b>
                </div>
                <div>
                    <a href="{{ $eventLink }}">
                        <span><i class="fal fa-map-marker-alt"></i></span>
                        {{ $eventLinkText }}
                    </a>
                </div>
            </div>
        @endif




        <div class="down">
            <div>
                <div class="title"><b>event details</b></div>
                <div>
                    <div>
                        <div><b>Event entry:</b></div>
                        <div class="text-danger  text-uppercase"><b>
                            @if($event->entry_type === \App\Models\Event::ENTRY_PAID)
                                £{{ $eventEntryPrice }}
                            @else
                                {{ \App\Models\Event::ALL_TYPES_ENTRY[$event->entry_type] }}
                            @endif</b></div>
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
            <div>
                <div class="title"><b>register here</b> (Seats available)</div>
                @empty($eventbriteCode)
                <div>
                    <div class="font-size-12"><b class="text-uppercase">
                            {{ $event->start_date->shortEnglishDayOfWeek }},
                            {{ $event->start_date->format('j F Y') }},
                            {{ \Carbon\Carbon::parse($event->start_time)->format('h:i') }}
                            @isset($event->end_time)
                                - {{ \Carbon\Carbon::parse($event->end_time)->format('h:i') }}
                            @endisset GMT
                        </b></div>
                    <div class="font-size-12 text-secondary">Sales end {{ $event->start_date->format('j F') }}</div>
                    <div class="line"></div>
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div><b>Female Seating</b></div>
                            <div>{{ $event->entry }}</div>
                        </div>
                        <div class="col-6 text-right">
                            <input type="number" value="1" min="0" max="1000" step="1"/>
                        </div>
                    </div>
                    <div class="line"></div>
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div><b>Male Seating</b></div>
                            <div>{{ $event->entry }}</div>
                        </div>
                        <div class="col-6 text-right">
                            <input type="number" value="1" min="0" max="1000" step="1"/>
                        </div>
                    </div>
                    <div class="line"></div>
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div><b>QTY: 0</b></div>
                        </div>
                        <div class="col-6 text-right"><a href="#" class="btn btn-secondary">Register</a></div>
                    </div>
                </div>
                @else
                {!! $eventbriteCode !!}
                @endempty
            </div>
        </div>
    </div>
</section>

<section class="blog-article-body">
    <div class="wrap">
        <div class="body">
            <h2>{{ $informationTitle }}</h2>
            {!! $informationTextMobile !!}
            <div class="pb-4"></div>
        </div>
    </div>
    @include('modules.presentation.share_this')
</section>

@include('modules.presentation.important_information', [
    'parameters' => $parameters
])

@include('modules.presentation.related_pages', [
    'parameters' => $parameters
])

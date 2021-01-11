@php

    $eventDescription = "";
    $previewPosition = "";

    $eventDateText = "";
    $eventTimeText = "";
    $eventLink = "";
    $eventLinkText = "";
    $eventEndSaleDate = "";

    $eventEntryPrice = "";
    $eventDetailsOrganiser = "";
    $eventDetailsSpeaker = "";
    $eventDetailsContact = "";

    $informationTitle ="";
    $informationText ="";
    $informationTextMobile ="";

    if (isset($parameters['event_description'])) {
        $eventDescription = $parameters['event_description'];
    }

    if (isset($parameters['preview_position'])) {
        $previewPosition = $parameters['preview_position'];
    }

    if (isset($parameters['event_date_text'])) {
        $eventDateText = $parameters['event_date_text'];
    }

    if (isset($parameters['event_time_text'])) {
        $eventTimeText = $parameters['event_time_text'];
    }

    if (isset($parameters['event_end_sale_date'])) {
        $eventEndSaleDate = $parameters['event_end_sale_date'];
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

    $event = $pageInstance->page->event;

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
                        <span class="place"><i class="fal fa-map-marker-alt"></i>
                            <span class="text-dark">{{ $event->location }}</span>
                        </span>
                    </div>
                    <h1>{{ $event->name }}</h1>
                    <p>{!! $eventDescription !!}</p>
                    <span class="date">{{ $event->start_date->format('M') }}
                        <span>
                            {{ $event->start_date->format('d') }}
                        </span>
                    </span>
                </div>
            </div>
            <div class="col-5">
            <img src="{{ $pageInstance->preview_img }}" alt="" class="w-100">
            </div>
        </div>
    </div>
</section>

<section class="event-info-descr">
    <div class="wrap">
        <div class="top">
            <div class="row align-items-center">
                <div class="col-6">
                    <b><i></i>{{ $event->start_date->format('l jS, F Y') }}</b>
                    <b>
                        {{ \Carbon\Carbon::parse($event->start_time)->format('h:ia') }}
                        @isset($event->end_time)
                             - {{ \Carbon\Carbon::parse($event->end_time)->format('h:ia') }}
                        @endisset
                    </b>
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
                            <div class="text-danger"><b>
                                @if($event->entry_type === \App\Models\Event::ENTRY_PAID)
                                    £{{ $eventEntryPrice }}
                                @else
                                    {{ \App\Models\Event::ALL_TYPES_ENTRY[$event->entry_type] }}
                                @endif
                                </b></div>
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
                            <div class="col-7"><b class="text-uppercase">
                                    {{ $event->start_date->shortEnglishDayOfWeek }},
                                    {{ $event->start_date->format('j F Y') }},
                                    {{ \Carbon\Carbon::parse($event->start_time)->format('h:i') }}
                                    @isset($event->end_time)
                                        - {{ \Carbon\Carbon::parse($event->end_time)->format('h:i') }}
                                    @endisset GMT</b></div>
                            <div class="col-5 text-right text-secondary">Sales end {{ $event->start_date->format('j F') }}</div>
                        </div>
                        <div class="line"></div>
                        <div class="row align-items-center">
                            <div class="col-7">
                                <div><b>Female Seating</b></div>
                                <div>{{ $event->entry }}</div>
                            </div>
                            <div class="col-5 text-right">
                                <input type="number" value="1" min="0" max="1000" step="1"/>
                            </div>
                        </div>
                        <div class="line"></div>
                        <div class="row align-items-center">
                            <div class="col-7">
                                <div><b>Male Seating</b></div>
                                <div>{{ $event->entry }}</div>
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
            {!! $informationText !!}
        </div>
    </div>
    @include('modules.presentation.share_this')
</section>

{{--<section class="blog-article-body">
    <div class="wrap">
        <div class="body">
            <h2>General subtitle right here, lorem ipsum exquisite.</h2>
            <p>Perspiciais und omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicab. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed consequuntur magni dolores eos qui rati voluptate sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.</p>
            <p>Perspiciais und omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicab. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed consequuntur magni dolores eos qui rati voluptate sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit. Perspiciais und omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicab. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit quia voluptas.</p>

            <div class="pt-4"></div>

            <div class="blog-video">
                <div class="img-video play-tr" style="background-image: url(img/content/Video-placement-2.jpg)"><i class="fas fa-play-circle"></i></div>
                <a href="#" class="view-more"><i class="moon-icons-arrow-right"></i></a>
            </div>

            <h2>General subtitle right here, lorem ipsum exquisite.</h2>
            <p>Perspiciais und omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicab. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed consequuntur magni dolores eos qui rati voluptate sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.</p>
        </div>
    </div>
</section>--}}

<div class="pt-5"></div>

@include('modules.presentation.important_information', [
    'parameters' => $parameters
])

@include('modules.presentation.related_page_expanded', [
    'parameters' => $parameters
])

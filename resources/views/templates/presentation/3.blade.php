@php

    $relatedPages = [];
    $hdrTypeActive = [];
    $hdrColorType = [];
    $hdrLinkText = [];
    $hdrLearnMoreLink = [];
    $hdrTitle = [];
    $hdrText = [];
    $hdrBgImage = [];

    for ($i=1; $i<=4; $i++) {
        $hdrColorType[$i] = "";
        $hdrTypeActive[$i] = "";
        $hdrLinkText[$i] = "";
        $hdrLearnMoreLink[$i] = "";
        $hdrTitle[$i] = "";
        $hdrText[$i] = "";
        $hdrBgImage[$i] = "";
        $donateLink[$i] = "";
    }

    for ($i = 1; $i <= 4; $i++) {
        if (isset($parameters['hdr_color_type_' . $i])) {
            $hdrColorType[$i] = $parameters['hdr_color_type_' . $i];
        }
        if (isset($parameters['hdr_type_active_' . $i])) {
            $hdrTypeActive[$i] = $parameters['hdr_type_active_' . $i];
        }
        if (isset($parameters['hdr_link_text_' . $i])) {
            $hdrLinkText[$i] = $parameters['hdr_link_text_' . $i];
        }
        if (isset($parameters['hdr_learn_more_link_' .$i])) {
            $hdrLearnMoreLink[$i] = $parameters['hdr_learn_more_link_' . $i];
        }
        if (isset($parameters['hdr_title_' .$i])) {
            $hdrTitle[$i] = $parameters['hdr_title_' . $i];
        }
        if (isset($parameters['hdr_text_' .$i])) {
            $hdrText[$i] = $parameters['hdr_text_' . $i];
        }
        if (isset($parameters['hdr_bg_image_' .$i])) {
            $hdrBgImage[$i] = $parameters['hdr_bg_image_' . $i];
        }
        if (isset($parameters['hdr_donate_link_' .$i])) {
            $donateLink[$i] = $parameters['hdr_donate_link_' . $i];
        }
    }

    $blogs = \App\Models\Page::lastBlogs(3);

    $style = 'style-1';

    if ((isset($hdrColorType[0])) && ($hdrColorType[0] === 'red')) {
        $style = 'style-2';
    }

@endphp

@empty(!$hdrTypeActive)

    <section class="main-page-header {{ $style }}" swiper-wrapper="header2">
        <div class="wrap">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @for ($i = 1; $i <= 4; $i++)
                        @if(in_array($i, $hdrTypeActive ))
                            @php
                                if ($hdrColorType[$i] === 'blue')  {
                                    $style = 'style-1';
                                }  else {
                                    $style = 'style-2';
                                }
                            @endphp
                            <div class="swiper-slide" data-style="{{ $style }}" header-slider-slide>
                                <div class="body">
                                    <div class="left">
                                        <div class="mb-4">
                                            <a href="{{ $hdrLearnMoreLink[$i] }}"
                                               class="learn-more text-underline text-dark"><b>{{ $hdrLinkText[$i] }}</b></a>
                                        </div>
                                        <div class="title mb-4">
                                            @if($hdrColorType[$i] === 'blue')
                                                {!! \App\Helpers\StrHelper::addSpanWithClass($hdrTitle[$i], 'text-info') !!}
                                            @else
                                                {!! \App\Helpers\StrHelper::addSpanWithClass($hdrTitle[$i], 'text-danger') !!}
                                            @endif
                                        </div>
                                        <p class="mb-5">{!! $hdrText[$i] !!}</p>
                                        <a href="{{ $donateLink[$i] }}"
                                           class="btn @if($hdrColorType[$i] === 'blue') btn-info @else btn-danger @endif">Donate
                                            now</a>
                                    </div>
                                    <a href="{{ $hdrLearnMoreLink[$i] }}" class="right"
                                       style="background-image: url('{{ $hdrBgImage[$i] }}')"></a>
                                    <a href="#" header-slider-next class="view-more swiper-button-next"><i
                                            class="moon-icons-arrow-right"></i></a>
                                </div>
                            </div>
                        @endif
                    @endfor
                </div>
            </div>
        </div>
    </section>

@endempty

@include('modules.presentation.quick_donation')

@include('modules.presentation.who_we_are')

@include('modules.presentation.our_work')

@include('modules.presentation.current_projects')

@include('modules.presentation.latest_projects')

@include('modules.presentation.lets_join')

@include('modules.presentation.view_all_projects')

@include('modules.presentation.what_new')

@include('modules.presentation.join_the_cause_subscribe2')


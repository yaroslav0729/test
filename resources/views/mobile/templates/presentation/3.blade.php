@php

$relatedPages = [];
$hdrTypeActive = [];
$hdrColorType = [];
$hdrLinkText = [];
$hdrLearnMoreLink = [];
$hdrTitle = [];
$hdrText = [];
$hdrBgImage = [];
$tagText = '';
$tagClass = '';

 $featuredCompaignLink = "";

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

    if (isset($parameters['feat_camp_link'])) {
        $featuredCompaignLink = $parameters['feat_camp_link'];
    }

    if (isset($parameters['tag_text'])) {
        $tagText = $parameters['tag_text'];
    }

    if (isset($parameters['tag_class'])) {
        $tagClass= $parameters['tag_class'];
    }

    $blogs = \App\Models\Page::lastBlogs(4);

    $style = 'style-1';

    if ((isset($hdrColorType[0])) && ($hdrColorType[0] === 'red')) {
        $style = 'style-2';
    }

@endphp

@empty(!$hdrTypeActive)
<section class="main-page-header {{ $style }}" swiper-wrapper="header-mabile-2">
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
                                    @empty($tagText)
                                        @if($hdrColorType[$i] === 'blue')
                                        <div class="tag bg-info-light text-info">Ramathan</div>
                                        @else
                                        <div class="tag bg-danger-light text-danger">Ramathan</div>
                                        @endif
                                    @else
                                        <div class="tag {{ $tagClass }}">{{ $tagText }}</div>
                                    @endempty
                                    <div class="title mb-3">
                                        <a href="{{ $hdrLearnMoreLink[$i] }}" class="text-dark text-decoration-none">
                                            @if($hdrColorType[$i] === 'blue')
                                                {!! \App\Helpers\StrHelper::addSpanWithClass($hdrTitle[$i], 'text-info') !!}
                                            @else
                                                {!! \App\Helpers\StrHelper::addSpanWithClass($hdrTitle[$i], 'text-danger') !!}
                                            @endif
                                        </a>
                                    </div>
                                        <a href="{{ $hdrLearnMoreLink[$i] }}" class="mb-3 text-dark text-decoration-none d-block">
                                            {!! $hdrText[$i] !!}
                                        </a>
                                    <a href="{{ $donateLink[$i] }}" style="position: relative; z-index: 2" class="btn @if($hdrColorType[$i] === 'blue') btn-info @else btn-danger @endif">Donate now</a>
                                    <div class="text-right mt-n4 d-block">
                                        <a href="#" header-slider-next class="view-more swiper-button-next"><i class="moon-icons-arrow-right"></i></a>
                                        <div class="black-line"></div>
                                    </div>
                                </div>
                                <a href="{{ $hdrLearnMoreLink[$i] }}" class="right" style="background-image: url('{{ $hdrBgImage[$i] }}')"></a>
                            </div>
                        </div>
                    @endif
                @endfor
            </div>
        </div>
    </div>
</section>
@endempty

@include('modules.presentation.who_we_are')

@include('modules.presentation.current_projects')

@include('modules.presentation.lets_join')

@include('modules.presentation.view_all_projects')

@include('modules.presentation.what_new')

@include('modules.presentation.join_the_cause_subscribe2')


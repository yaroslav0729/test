<div class="pt-5"></div>

<section class="mission-impossible">
    <div class="wrap">
        <div class="title">
            @isset($parameters[\App\Models\WidgetParameters::PARAM_TITLE])
                {{ $parameters[\App\Models\WidgetParameters::PARAM_TITLE] }}
            @endisset 
        </div>
    </div>
    <div class="wrap">
    <div class="body">
        <div class="row gutter-0">
            <div class="col-7" style="z-index: 2">
                <div class="text bg-danger">
                    <div class="tl">
                        @isset($parameters[\App\Models\WidgetParameters::PARAM_OPEN_TEXT])
                            {{ $parameters[\App\Models\WidgetParameters::PARAM_OPEN_TEXT] }}
                        @endisset 
                    </div>
                    <p>
                        @isset($parameters[\App\Models\WidgetParameters::PARAM_REFERENCE])
                            {{ $parameters[\App\Models\WidgetParameters::PARAM_REFERENCE] }}
                        @endisset 
                    </p>
                </div>
                <div class="text-right">
                    @isset($parameters[\App\Models\WidgetParameters::PARAM_LINK])
                        @php
                            $link = $parameters[\App\Models\WidgetParameters::PARAM_LINK]
                        @endphp
                    @else 
                        @php $link = "#"; @endphp
                    @endisset 
                    <a href="{{ $link }}" class="btn btn-danger-light view-more">Learn more</a>
                </div>
            </div>
            @isset($parameters[\App\Models\WidgetParameters::PARAM_BG_IMAGE])
                @php
                    $bgImage = $parameters[\App\Models\WidgetParameters::PARAM_BG_IMAGE]
                @endphp
            @else 
                @php $bgImage = "/"; @endphp
            @endisset
            <div class="col-5 img" style="background-image: url({{ $bgImage }})">&nbsp;</div>
        </div>
    </div>
    </div>
</section>

<div class="pt-5"></div>
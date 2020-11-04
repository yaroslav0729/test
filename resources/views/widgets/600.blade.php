<section class="join-cause-2">
    <div class="wrap">
        <div>
            <div class="row align-items-center">
                <div class="col-7">
                    <div class="title mb-3">
                        <p class="font-size-30">
                            <b>
                                @isset($parameters[\App\Models\WidgetParameters::PARAM_TITLE])
                                    {{ $parameters[\App\Models\WidgetParameters::PARAM_TITLE] }}
                                @endisset  
                            </b>
                        </p>
                    </div>
                    <p  class="font-size-20 mb-5">
                        @isset($parameters[\App\Models\WidgetParameters::PARAM_HTML])
                            {!! $parameters[\App\Models\WidgetParameters::PARAM_HTML] !!}
                        @endisset
                    </p>
                </div>
                <div class="col-5 pr-4">

                    @isset($parameters[\App\Models\WidgetParameters::PARAM_BG_IMAGE])
                        <img src="{{ $parameters[\App\Models\WidgetParameters::PARAM_BG_IMAGE] }}" alt="" class="w-100">
                    @endisset

                    <i class="fal fa-plus decor-plus"></i>
                </div>
            </div>
        </div>
    </div>
</section>
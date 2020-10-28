<div class="widget_layout">

    @isset($parameters[\App\Models\WidgetParameters::PARAM_GROUP])
        <span class="font-weight-bold ">Group: {{ $parameters[\App\Models\WidgetParameters::PARAM_GROUP] }}</span><br>
    @endisset

    @isset($parameters[\App\Models\WidgetParameters::PARAM_ELEMENTS_QUANT])
        <span class="font-weight-bold ">Elements quantity: {{ $parameters[\App\Models\WidgetParameters::PARAM_ELEMENTS_QUANT] }}</span><br>
    @endisset

    @isset($parameters[\App\Models\WidgetParameters::PARAM_PAGES_QUANT])
        <span class="font-weight-bold ">Pages quantity: {{ $parameters[\App\Models\WidgetParameters::PARAM_PAGES_QUANT] }}</span><br>
    @endisset

</div>
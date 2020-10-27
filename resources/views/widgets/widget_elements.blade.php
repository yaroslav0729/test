<div class="widget-item border border-dark rounded p-3 mb-3">
    <h2 class="mt-1 mb-3">{{  \App\Models\Widget::WIDGET_LABELS[$widgetId] }}</h2>
    
    <div class="border rounded p-3 mb-3">
        {!! $widgetHtml !!}
    </div>

    <div class="border rounded p-3">
        @foreach ($availableParameters as $param)
            @switch($param)
                @case(\App\Models\WidgetParameters::PARAM_HTML)
                        <textarea name="widget_">@isset($parameters[\App\Models\WidgetParameters::PARAM_HTML]){!! $parameters[\App\Models\WidgetParameters::PARAM_HTML] !!}@endisset</textarea>
                    @break

                @case(\App\Models\WidgetParameters::PARAM_GROUP)
                        PARAM_GROUP<br>
                    @break

                @case(\App\Models\WidgetParameters::PARAM_ELEMENTS_QUANT)
                        PARAM_ELEMENTS_QUANT<br>
                    @break

                @case(\App\Models\WidgetParameters::PARAM_PAGES_QUANT)
                        PARAM_PAGES_QUANT<br>
                    @break

                @default
                    <div class="alert alert-danger">Unknown parameter (id: {{ $param }})</div>
            @endswitch
        @endforeach
    </div>

    <div class="mt-3 p-3 border widget_buttons">
        <button type="button" btn-down class="btn btn-success"><i class="fas fa-arrow-down"></i></button>
        <button type="button" btn-up class="btn btn-success"><i class="fas fa-arrow-up"></i></button>
        <button type="button" btn-delete class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
    </div>
</div>
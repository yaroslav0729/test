{{--

received parameters
    
- $itemId - not required
- $widgetId
- $availableParameters
- $parameters - not required

--}}

<div class="widget-item border border-dark rounded p-3 mb-3">
    {{-- <h3 class="mt-1 mb-3">{{  \App\Models\Widget::WIDGET_LABELS[$widgetId] }}</h3> --}}

    <div class="">

        @foreach ($availableParameters as $param)

            @if ($param !== \App\Models\WidgetParameters::PARAM_HTML)
                <label class="mb-2">{{ \App\Models\WidgetParameters::PARAM_LABELS[$param] }}</label>
            @endif
            
            @php
                $inputName = "";

                if (!isset($itemId)) {
                    $itemId = "new-" . \Illuminate\Support\Str::random(20);
                }
            
                $inputName = "widget_param_" . $itemId . "_" . $widgetId . "_";
            @endphp

            @switch($param)
                    @case(\App\Models\WidgetParameters::PARAM_EMPTY)
                        @php
                            $inputName = $inputName . \App\Models\WidgetParameters::PARAM_EMPTY;
                        @endphp
                        <div class="form-group">
                            <input 
                                name="{{ $inputName }}" 
                                type="hidden" 
                                value="" 
                            />
                        </div>
                    @break
                @case(\App\Models\WidgetParameters::PARAM_HTML)
                        @php
                            $inputName = $inputName . \App\Models\WidgetParameters::PARAM_HTML;
                        @endphp
                        <div class="form-group">
                            <textarea wysiwyg-editor id="{{ $inputName }}" name="{{ $inputName }}" class="form-control">@isset($parameters[\App\Models\WidgetParameters::PARAM_HTML]){!! $parameters[\App\Models\WidgetParameters::PARAM_HTML] !!}@endisset</textarea>
                        </div>
                    @break

                @case(\App\Models\WidgetParameters::PARAM_GROUP)
                        @php
                            $inputName = $inputName . \App\Models\WidgetParameters::PARAM_GROUP;
                        @endphp
                        <div class="form-group mb-3">
                            <select name="{{ $inputName }}" multiple class="form-control">
                                <option value="1">Param group 1</option>
                                <option value="2">Param group 2</option>
                                <option value="3">Param group 3</option>
                            </select>
                        </div>
                    @break

                @case(\App\Models\WidgetParameters::PARAM_ELEMENTS_QUANT)
                        @php
                            $inputName = $inputName . \App\Models\WidgetParameters::PARAM_ELEMENTS_QUANT;
                        @endphp
                        <div class="input-group mb-3">
                            <input 
                                name="{{ $inputName }}" 
                                type="number" 
                                class="form-control" 
                                placeholder="Quantity of elements"
                                @isset($parameters[\App\Models\WidgetParameters::PARAM_ELEMENTS_QUANT]) 
                                    value="{{ $parameters[\App\Models\WidgetParameters::PARAM_ELEMENTS_QUANT] }}" 
                                @endisset
                            />
                        </div>
                        
                    @break

                @case(\App\Models\WidgetParameters::PARAM_PAGES_QUANT)
                        @php
                            $inputName = $inputName . \App\Models\WidgetParameters::PARAM_PAGES_QUANT;
                        @endphp
                        <div class="input-group mb-3">
                            <input 
                                name="{{ $inputName }}" 
                                type="number" 
                                class="form-control" 
                                placeholder="Quantity of pages"
                                @isset($parameters[\App\Models\WidgetParameters::PARAM_PAGES_QUANT]) 
                                    value="{{ $parameters[\App\Models\WidgetParameters::PARAM_PAGES_QUANT] }}" 
                                @endisset 
                            />
                        </div>
                    @break

                @default
                    <div class="alert alert-danger">Unknown parameter (id: {{ $param }})</div>
            @endswitch
        @endforeach
    </div>

    <div class="widget_buttons">
        <button type="button" btn-down class="btn btn-success"><i class="fas fa-arrow-down"></i></button>
        <button type="button" btn-up class="btn btn-success"><i class="fas fa-arrow-up"></i></button>
        <button type="button" btn-delete class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
    </div>
</div>
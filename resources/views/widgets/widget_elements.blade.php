{{--

received parameters
    
- $itemId - not required
- $widgetId
- $availableParameters
- $parameters - not required

--}}

<div class="widget-item border border-dark rounded p-3 mb-3">
    <h3 class="mt-1 mb-3 text-center">{{  \App\Models\Widget::WIDGET_LABELS[$widgetId] }}</h3>

    <div class="">

        @empty($availableParameters)
            <label class="mb-2">No parameters in this widget</label>

            @php
                $inputName = "";

                if (!isset($itemId)) {
                    $itemId = "new-" . \Illuminate\Support\Str::random(20);
                }

                $inputName = "widget_param_" . $itemId . "_" . $widgetId . "_0";

            @endphp

            <div class="form-group">
                <input 
                    name="{{ $inputName }}" 
                    type="hidden" 
                    value="" 
                />
            </div>
        @endempty

        @foreach ($availableParameters as $param)

            @if ($param !== \App\Models\WidgetParameters::PARAM_HTML)
                <label class="mb-2">{{ \App\Models\WidgetParameters::PARAM_LABELS[$param] }}</label>
            @endif
            
            @php
                $inputName = "";

                if (!isset($itemId)) {
                    $itemId = "new-" . \Illuminate\Support\Str::random(20);
                }
            
                $inputName = "widget_param_" . $itemId . "_" . $widgetId . "_" . $param;
            @endphp

            @switch($param)

                @case(\App\Models\WidgetParameters::PARAM_TITLE)

                    <div class="input-group mb-3">
                        <input 
                            name="{{ $inputName }}" 
                            type="text" 
                            class="form-control" 
                            placeholder="{{ \App\Models\WidgetParameters::PARAM_LABELS[$param] }}"
                            @isset($parameters[$param]) 
                                value="{{ $parameters[$param] }}" 
                            @endisset
                        />
                    </div>
                    
                @break

                @case(\App\Models\WidgetParameters::PARAM_HTML)
                    <div class="form-group">
                        <textarea wysiwyg-editor id="{{ $inputName }}" name="{{ $inputName }}" class="form-control">@isset($parameters[$param]){!! $parameters[$param] !!}@endisset</textarea>
                    </div>
                @break

                @case(\App\Models\WidgetParameters::PARAM_MAIN_TEXT)
                    <div class="form-group">
                        <textarea id="{{ $inputName }}" name="{{ $inputName }}" class="form-control">@isset($parameters[$param]){!! $parameters[$param] !!}@endisset</textarea>
                    </div>
                @break

                @case(\App\Models\WidgetParameters::PARAM_ADDITIONAL_TEXT)
                    <div class="form-group">
                        <textarea id="{{ $inputName }}" name="{{ $inputName }}" class="form-control">@isset($parameters[$param]){!! $parameters[$param] !!}@endisset</textarea>
                    </div>
                @break

                @case(\App\Models\WidgetParameters::PARAM_GROUP)
                    <div class="form-group mb-3">
                        <select name="{{ $inputName }}" multiple class="form-control">
                            <option value="1">Param group 1</option>
                            <option value="2">Param group 2</option>
                            <option value="3">Param group 3</option>
                        </select>
                    </div>
                @break

                @case(\App\Models\WidgetParameters::PARAM_BG_IMAGE)
                    <div class="input-group mb-3">
                        <input 
                            name="{{ $inputName }}" 
                            type="text" 
                            class="form-control" 
                            placeholder="{{ \App\Models\WidgetParameters::PARAM_LABELS[$param] }}"
                            @isset($parameters[$param]) 
                                value="{{ $parameters[$param] }}" 
                            @endisset
                        />
                    </div>
                    
                @break

                @case(\App\Models\WidgetParameters::PARAM_READ_STRING)
                    <div class="input-group mb-3">
                        <input 
                            name="{{ $inputName }}" 
                            type="text" 
                            class="form-control" 
                            placeholder="{{ \App\Models\WidgetParameters::PARAM_LABELS[$param] }}"
                            @isset($parameters[$param]) 
                                value="{{ $parameters[$param] }}" 
                            @endisset
                        />
                    </div>
                    
                @break


                @case(\App\Models\WidgetParameters::PARAM_LINK)
                    <div class="input-group mb-3">
                        <input 
                            name="{{ $inputName }}" 
                            type="text" 
                            class="form-control" 
                            placeholder="{{ \App\Models\WidgetParameters::PARAM_LABELS[$param] }}"
                            @isset($parameters[$param]) 
                                value="{{ $parameters[$param] }}" 
                            @endisset
                        />
                    </div>
                    
                @break

                @case(\App\Models\WidgetParameters::PARAM_ELEMENTS_QUANT)
                    <div class="input-group mb-3">
                        <input 
                            name="{{ $inputName }}" 
                            type="number" 
                            class="form-control" 
                            placeholder="{{ \App\Models\WidgetParameters::PARAM_LABELS[$param] }}"
                            @isset($parameters[$param]) 
                                value="{{ $parameters[$param] }}" 
                            @endisset
                        />
                    </div>
                @break

                @case(\App\Models\WidgetParameters::PARAM_PAGES_QUANT)
                    <div class="input-group mb-3">
                        <input 
                            name="{{ $inputName }}" 
                            type="number" 
                            class="form-control" 
                            placeholder="{{ \App\Models\WidgetParameters::PARAM_LABELS[$param] }}"
                            @isset($parameters[$param]) 
                                value="{{ $parameters[$param] }}" 
                            @endisset 
                        />
                    </div>
                @break

                @case(\App\Models\WidgetParameters::PARAM_VIDEO_LINKS)
                    <div class="form-group" options-container>

                        <div class="btn btn-info mb-3" option-add><i class="fas fa-link"></i> Add link</div>

                        <div class="d-none" item-option-stub stub-fields>
                            <div class="input-group mb-3" >
                                <input 
                                    name="{{ $inputName }}[]" 
                                    type="text"
                                    class="form-control" 
                                    placeholder="add link here..."
                                    value=""
                                />
                            </div>
                        </div>

                        @php
                            if (isset($parameters[$param])) {
                                $videoLinks = $parameters[$param];
                            }
                        @endphp
                        
                        <div answers-list>
                        @isset($videoLinks)
                            @foreach ($videoLinks as $link)
                            <div class="input-group mb-3">
                                <input 
                                    name="{{ $inputName }}[]" 
                                    type="text"
                                    class="form-control" 
                                    placeholder="{{ \App\Models\WidgetParameters::PARAM_LABELS[$param] }}"
                                    value="{{ $link }}" 
                                />
                            </div>
                            @endforeach
                        @endisset
                        </div>
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
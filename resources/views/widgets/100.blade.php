<div class="widget-item border border-dark rounded p-3 mb-3">
    <div class="border rounded p-3">
        <h3>{{ \App\Models\Widget::WIDGET_LABELS[\App\Models\Widget::WIDGET_RICH_TEXT] }}</h3>
        <textarea class="widget_{{ \App\Models\Widget::WIDGET_RICH_TEXT }}">@isset($parameters['data']){!! $parameters['data'] !!}@endisset</textarea>
    </div>
    <div class="mt-3 p-3 border widget_buttons">
        <button type="button" btn-down class="btn btn-success"><i class="fas fa-arrow-down"></i></button>
        <button type="button" btn-up class="btn btn-success"><i class="fas fa-arrow-up"></i></button>
        <button type="button" btn-delete class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
    </div>
</div>
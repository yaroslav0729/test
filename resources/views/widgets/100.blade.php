<h3>{{ \App\Models\Widget::WIDGET_LABELS[\App\Models\Widget::WIDGET_RICH_TEXT] }}</h3>
<textarea class="widget_{{ \App\Models\Widget::WIDGET_RICH_TEXT }}">
@isset($parameters['data']){!! $parameters['data'] !!}@endisset
</textarea>
<br>
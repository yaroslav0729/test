<h3>{{ \App\Models\Widget::WIDGET_LABELS[\App\Models\Widget::WIDGET_GROUP_TILES] }}</h3>
<div>
    @isset($parameters['data'])
        {!! $parameters['data'] !!}
    @endisset
</div>
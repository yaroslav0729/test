@php

    $mainHtml = "";

    if (isset($parameters['main_html'])) {
        $mainHtml = $parameters['main_html'];    
    }

@endphp

@if(isset($pageInstance->html))
<a href="{{ $pageInstance->html }}" target="_blank">old page</a>
@endif

<div class="container">
    <h1 class="text-center">{{ $pageInstance->name }}</h1>
    <h2>{{ $pageInstance->preview_text }}</h2>
    <div class="date">
        <i class="fas fa-calendar-alt"></i>
        <span>{{ date('d F Y', strtotime($pageInstance->published_at)) }}</span>
    </div>
    {!! $mainHtml !!}
</div>

@include('modules.presentation.join_the_cause_subscribe')

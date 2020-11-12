@php

    $mainHtml = "";

    if (isset($parameters['main_html'])) {
        $mainHtml = $parameters['main_html'];    
    }

@endphp

<div class="container">
    <h1 class="text-center">{{ $pageInstance->name }}</h1>
    {!! $mainHtml !!}
</div>

@include('modules.presentation.join_the_cause_subscribe')

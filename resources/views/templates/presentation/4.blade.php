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
    <div class="row padding">
        <div class="col-lg-12">
            <h1 class="text-center">{{ $pageInstance->name }}</h1>
            <h2>{{ $pageInstance->preview_text }}</h2>
            <div class="date pt-4 pb-4">
                <i class="fas fa-calendar-alt"></i>
                <span>{{ date('d F Y', strtotime($pageInstance->published_at)) }}</span>
            </div>
        </div>
    </div>

    {!! $mainHtml !!}
    
</div>

@include('modules.presentation.join_the_cause_subscribe')

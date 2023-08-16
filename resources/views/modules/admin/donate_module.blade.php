@php

    $donateImg = "";
    $donateVideo = "";
    $donateText = "";

    if (isset($parameters['donate_img'])) {
        $donateImg = $parameters['donate_img'];    
    }

    if (isset($parameters['donate_video'])) {
        $donateVideo = $parameters['donate_video'];    
    }

    if (isset($parameters['donate_text'])) {
        $donateText = $parameters['donate_text'];    
    }

@endphp

<h3 class="text-center">Projects donate module:</h3>

<div class="form-group">
    <label>Donate module image:</label>
    <input class="form-control" name="parameters[donate_img]" placeholder="Insert donate img path" value="{{ $donateImg }}" />
</div>

<div class="form-group">
    <label>Donate module video:</label>
    <input class="form-control" name="parameters[donate_video]" placeholder="Insert donate video id" value="{{ $donateVideo }}" />
</div>

<div class="form-group">
    <label>Donate module text:</label>
    <textarea class="form-control" placeholder="Insert donate module text" name="parameters[donate_text]">{{ $donateText }}</textarea>
</div>

<ul class="nav nav-tabs" id="currentProjects" role="tablist" style="">
    <li class="nav-item">
        <a class="nav-link active" id="tab-slide-1" data-toggle="tab" href="#slide_1" role="tab" aria-controls="tab-slide-1" aria-selected="true">Single donation</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="tab-slide-2" data-toggle="tab" href="#slide_2" role="tab" aria-controls="tab-slide-2" aria-selected="false">Monthly donation</a>
    </li>
</ul>

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="slide_1" role="tabpanel" aria-labelledby="tab-slide-1">
        @include('templates.form.parts.donation_options', [
            'parameters' => $parameters,
            'donationType' => \App\Models\CampaignPrice::TYPE_SINGLE
        ])
    </div>
    <div class="tab-pane fade" id="slide_2" role="tabpanel" aria-labelledby="tab-slide-2">
        @include('templates.form.parts.donation_options', [
            'parameters' => $parameters,
            'donationType' => \App\Models\CampaignPrice::TYPE_MONTHLY
        ])
    </div>
    {{-- 
    @isset($useAppeal)
    <div class="tab-pane fade" id="slide_3" role="tabpanel" aria-labelledby="tab-slide-3">
        Appeal donation
    </div>
    @endisset 
    --}}
</div>


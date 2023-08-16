@php

    $experienceVideo = "";
    $expTitle = "";
    $expText2 = "";
    $expDate1 = "";
    $expText3 = "";
    $expQuote = "";

    if (isset($parameters['exp_video'])) {
        $experienceVideo = $parameters['exp_video'];    
    }

    if (isset($parameters['exper_title'])) {
        $expTitle = $parameters['exper_title'];    
    }

    if (isset($parameters['exp_text2'])) {
        $expText2 = $parameters['exp_text2'];    
    }

    if (isset($parameters['exp_date1'])) {
        $expDate1 = $parameters['exp_date1'];    
    }

    if (isset($parameters['exp_text3'])) {
        $expText3 = $parameters['exp_text3'];    
    }

    if (isset($parameters['exp_quote'])) {
        $expQuote = $parameters['exp_quote'];    
    }

@endphp

<h3 class="text-center">Experience of a lifetime module:</h3>

<div class="form-group">
    <label>Experience video:</label>
    <input class="form-control" name="parameters[exp_video]" placeholder="Insert video id" value="{{ $experienceVideo }}" />
</div>

<div class="form-group">
    <label>Experience title:</label>
    <input class="form-control" name="parameters[exper_title]" placeholder="Insert title" value="{{ $expTitle }}" />
</div>

<div class="form-group">
    <label>Experience text 2:</label>
    <input class="form-control" name="parameters[exp_text2]" placeholder="Insert text 2" value="{{ $expText2 }}" />
</div>

<div class="form-group">
    <label>Experience date 1:</label>
    <input class="form-control" name="parameters[exp_date1]" placeholder="Insert date 1" value="{{ $expDate1 }}" />
</div>

<div class="form-group">
    <label>Experience text 3:</label>
    <input class="form-control" name="parameters[exp_text3]" placeholder="Insert text 3" value="{{ $expText3 }}" />
</div>

<div class="form-group">
    <label>Experience quote:</label>
    <input class="form-control" name="parameters[exp_quote]" placeholder="Insert quote" value="{{ $expQuote }}" />
</div>
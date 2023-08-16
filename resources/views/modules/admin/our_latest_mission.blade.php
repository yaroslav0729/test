@php

    $ourLatestTitle = "";
    $ourLatestCountry = "";
    $ourLatestText1 = "";
    $ourLatestText2 = "";
    $ourLatestLink = "";

    if (isset($parameters['our_latest_title'])) {
        $ourLatestTitle = $parameters['our_latest_title'];    
    }

    if (isset($parameters['our_latest_country'])) {
        $ourLatestCountry = $parameters['our_latest_country'];    
    }

    if (isset($parameters['our_latest_text1'])) {
        $ourLatestText1 = $parameters['our_latest_text1'];    
    }

    if (isset($parameters['our_latest_text2'])) {
        $ourLatestText2 = $parameters['our_latest_text2'];    
    }

    if (isset($parameters['our_latest_link'])) {
        $ourLatestLink = $parameters['our_latest_link'];    
    }

@endphp

<h3 class="text-center">Our latest mission module:</h3>

<div class="form-group">
    <label>Our latest title:</label>
    <input class="form-control" name="parameters[our_latest_title]" placeholder="Insert title" value="{{ $ourLatestTitle }}" />
</div>

<div class="form-group">
    <label>Our latest country:</label>
    <input class="form-control" name="parameters[our_latest_country]" placeholder="Insert text" value="{{ $ourLatestCountry }}" />
</div>

<div class="form-group">
    <label>Our latest text 1:</label>
    <input class="form-control" name="parameters[our_latest_text1]" placeholder="Insert text" value="{{ $ourLatestText1 }}" />
</div>

<div class="form-group">
    <label>Our latest text 2:</label>
    <input class="form-control" name="parameters[our_latest_text2]" placeholder="Insert text" value="{{ $ourLatestText2 }}" />
</div>

<div class="form-group">
    <label>Our latest link:</label>
    <input class="form-control" name="parameters[our_latest_link]" placeholder="Insert link" value="{{ $ourLatestLink }}" />
</div>
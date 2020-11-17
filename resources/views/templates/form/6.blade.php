@php

    $donationText = "";
    $donationVideo = "";
    $donationVideoLink = "";


    if (isset($parameters['donation_text'])) {
        $donationText = $parameters['donation_text'];
    }

    if (isset($parameters['donation_video'])) {
        $donationVideo = $parameters['donation_video'];
    }

    if (isset($parameters['donation_link'])) {
        $donationVideoLink = $parameters['donation_link'];
    }

@endphp

<div class="row">
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Thank you your donation text (max 60 characters):</label>
            <input class="form-control" required name="parameters[donation_text]"
                   placeholder="Insert text" maxlength="60"
                   value="{{ $donationText }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Youtube video link:</label>
            <input class="form-control " required name="parameters[donation_video]"
                   placeholder="Insert youtube video link"
                   value="{{ $donationVideo }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>View story link:</label>
            <input class="form-control " required name="parameters[donation_link]"
                   placeholder="Insert link to page"
                   value="{{ $donationVideoLink }}"/>
        </div>
    </div>
</div>

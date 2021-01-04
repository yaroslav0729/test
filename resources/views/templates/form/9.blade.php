@php

    $donationText = "";
    $donationArticleTitle = "";
    $donationVideo = "";
    $donationVideoLinkTitle = "";
    $donationVideoLink = "";


    if (isset($parameters['donation_text'])) {
        $donationText = $parameters['donation_text'];
    }

    if (isset($parameters['donation_article_title'])) {
        $donationArticleTitle = $parameters['donation_article_title'];
    }

    if (isset($parameters['donation_video'])) {
        $donationVideo = $parameters['donation_video'];
    }

    if (isset($parameters['donation_link_title'])) {
        $donationVideoLinkTitle = $parameters['donation_link_title'];
    }

    if (isset($parameters['donation_link'])) {
        $donationVideoLink = $parameters['donation_link'];
    }

@endphp

<div class="row">
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Thank you your donation text (Use square brackets to highlight text, [Thank you, your donation could] empower 512 people. - for example):</label>
            <input class="form-control" name="parameters[donation_text]"
                   placeholder="Insert text"
                   value="{{ $donationText }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Article title (max 60 characters):</label>
            <input class="form-control" name="parameters[donation_article_title]"
                   placeholder="Article title" maxlength="60"
                   value="{{ $donationArticleTitle }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Youtube video link:</label>
            <input class="form-control" name="parameters[donation_video]"
                   placeholder="Insert youtube video link"
                   value="{{ $donationVideo }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>View story link title:</label>
            <input class="form-control" name="parameters[donation_link_title]"
                   placeholder="View story link title"
                   value="{{ $donationVideoLinkTitle }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>View story link:</label>
            <input class="form-control" name="parameters[donation_link]"
                   placeholder="Insert link to page"
                   value="{{ $donationVideoLink }}"/>
        </div>
    </div>
</div>

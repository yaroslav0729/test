@php

    $bgImage = "";

    $headOfficeTitle = "";
    $headOfficeText = "";
    $foreignOfficeTitle = "";
    $foreignOfficeText = "";

    $email = "";
    $instagramLink = "";
    $facebookLink = "";
    $youtubeLink = "";
    $twitterLink = "";

    if (isset($parameters['background_image'])) {
        $bgImage = $parameters['background_image'];
    }

    if (isset($parameters['head_office_title'])) {
        $headOfficeTitle = $parameters['head_office_title'];
    }

    if (isset($parameters['head_office_text'])) {
        $headOfficeText = $parameters['head_office_text'];
    }

    if (isset($parameters['foreign_office_title'])) {
        $foreignOfficeTitle = $parameters['foreign_office_title'];
    }

    if (isset($parameters['foreign_office_text'])) {
        $foreignOfficeText = $parameters['foreign_office_text'];
    }

    if (isset($parameters['contact_email'])) {
        $email = $parameters['contact_email'];
    }

    if (isset($parameters['instagram_link'])) {
        $instagramLink = $parameters['instagram_link'];
    }

    if (isset($parameters['facebook_link'])) {
        $facebookLink = $parameters['facebook_link'];
    }

    if (isset($parameters['youtube_link'])) {
        $youtubeLink = $parameters['youtube_link'];
    }

    if (isset($parameters['twitter_link'])) {
        $twitterLink = $parameters['twitter_link'];
    }

@endphp

<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label>Background image title:</label>
            <input class="form-control " required name="parameters[background_image]"
                   placeholder="Insert background image name"
                   value="{{ $bgImage }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6 mt-5">
        <div class="form-group">
            <label>Head office title:</label>
            <input class="form-control " required name="parameters[head_office_title]"
                   placeholder="Insert Title"
                   value="{{ $headOfficeTitle }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6 mt-5">
        <div class="form-group">
            <label>Foreign office title:</label>
            <input class="form-control " required name="parameters[foreign_office_title]"
                   placeholder="Insert Title"
                   value="{{ $foreignOfficeTitle }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Head office text:</label>
            <textarea class="form-control" name="parameters[head_office_text]"
                      placeholder="Text">{!! $headOfficeText !!}</textarea>

        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Foreign office text:</label>
            <textarea class="form-control" name="parameters[foreign_office_text]"
                      placeholder="Text">{!! $foreignOfficeText !!}</textarea>

        </div>
    </div>

    <div class="col-12 col-lg-6 mt-5">
        <div class="form-group">
            <label>Email:</label>
            <input class="form-control " required name="parameters[contact_email]"
                   placeholder="Insert email address"
                   value="{{ $email }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6 mt-5">
        <div class="form-group">
            <label>Instagram link:</label>
            <input class="form-control " required name="parameters[instagram_link]"
                   placeholder="Insert instagram link"
                   value="{{ $instagramLink }}"/>

        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Facebook link:</label>
            <input class="form-control " required name="parameters[facebook_link]"
                   placeholder="Insert facebook link"
                   value="{{ $facebookLink }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Youtube link:</label>
            <input class="form-control " required name="parameters[youtube_link]"
                   placeholder="Insert youtube link"
                   value="{{ $youtubeLink }}"/>

        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Twitter link:</label>
            <input class="form-control " required name="parameters[twitter_link]"
                   placeholder="Insert twitter link"
                   value="{{ $twitterLink }}"/>

        </div>
    </div>
    <div class="col-12 mt-5">
        @include('modules.admin.join_the_cause_subscribe', [
            'parameters' => $parameters
        ])
    </div>

    <div class="col-12 mt-5">
        @include('modules.admin.related_pages', [
            'parameters' => $parameters
        ])
    </div>
</div>


{{--
@include('modules.admin.related_pages', [
    'parameters' => $parameters
])

@include('modules.admin.join_the_cause_subscribe', [
    'parameters' => $parameters
])
--}}

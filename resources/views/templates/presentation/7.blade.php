@php
    $bgImage = "";
    $upperPhrase = "";
    $bottomPhrase = "";

    $headText = "";

    $headOfficeTitle = "";
    $headOfficeText = "";
    $foreignOfficeTitle = "";
    $foreignOfficeText = "";

    $emailTitle = "";
    $email = "";

    $instagramLink = "";
    $facebookLink = "";
    $youtubeLink = "";
    $twitterLink = "";

    if (isset($parameters['upper_phrase'])) {
        $upperPhrase = $parameters['upper_phrase'];
    }

    if (isset($parameters['bottom_phrase'])) {
        $bottomPhrase = $parameters['bottom_phrase'];
    }

    if (isset($parameters['background_image'])) {
        $bgImage = $parameters['background_image'];
    }

    if (isset($parameters['head_text'])) {
        $headText = $parameters['head_text'];
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

    if (isset($parameters['contact_email_title'])) {
        $emailTitle = $parameters['contact_email_title'];
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

<section class="who-we-are-head" style="background-image: url({{ $bgImage }});">
    <br>
    <br>
    <div>{{ $upperPhrase }}</div>
    <h1>{{ $bottomPhrase }}</h1>
</section>

<section class="contacts">
    <div class="wrap">
        <h2>{{ $headText }}</h2>
        <div class="row gutter-30">
            <div class="col-12 col-md-6 col-lg-3">
                <h3>{{ $headOfficeTitle }}</h3>
                <p>{!! $headOfficeText !!}</p>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <h3>{{ $foreignOfficeTitle }}</h3>
                <p>{!! $foreignOfficeText !!}</p>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <h3>{{ $emailTitle }}</h3>
                <p>{{ $email }}</p>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <h3>Connect</h3>
                <div class="social d-flex justify-content-between">
                    <a href="{{ $instagramLink }}"><i class="fab fa-instagram"></i></a>
                    <a href="{{ $facebookLink }}"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{ $youtubeLink }}"><i class="fab fa-youtube"></i></a>
                    <a href="{{ $twitterLink }}"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

@include('modules.presentation.related_topics_project', [
    'parameters' => $parameters
])


@include('modules.presentation.join_the_cause_subscribe')

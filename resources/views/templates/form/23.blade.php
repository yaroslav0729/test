@php

    $mainTitle = '';
    $mainImage = '';
    $applyLink = '';
    $latestMissionText = '';
    $latestMissionDate = '';
    $colTitle1 = '';
    $colText1 = '';
    $colTitle2 = '';
    $colText2 = '';
    $colTitle3 = '';
    $colText3 = '';
    $exploreTitle = '';
    $exploreText = '';
    $interestedTitle = '';
    $interestedText = '';
    $volonteerNowLink = '';
    $projImg1 = '';
    $projText1 = '';
    $projImg2 = '';
    $projText2 = '';
    $widgetHtml = '';

    if (isset($parameters['main_title'])) {
        $mainTitle = $parameters['main_title'];
    }

    if (isset($parameters['main_image'])) {
        $mainImage = $parameters['main_image'];
    }

    if (isset($parameters['apply_link'])) {
        $applyLink = $parameters['apply_link'];
    }

    if (isset($parameters['latest_mission_text'])) {
        $latestMissionText = $parameters['latest_mission_text'];
    }

    if (isset($parameters['latest_mission_date'])) {
        $latestMissionDate = $parameters['latest_mission_date'];
    }

    if (isset($parameters['column1_title'])) {
        $colTitle1 = $parameters['column1_title'];
    }

    if (isset($parameters['column1_text'])) {
        $colText1 = $parameters['column1_text'];
    }

    if (isset($parameters['column2_title'])) {
        $colTitle2 = $parameters['column2_title'];
    }

    if (isset($parameters['column2_text'])) {
        $colText2 = $parameters['column2_text'];
    }

    if (isset($parameters['column2_title'])) {
        $colTitle3 = $parameters['column2_title'];
    }

    if (isset($parameters['column3_text'])) {
        $colText3 = $parameters['column3_text'];
    }

    if (isset($parameters['explore_proj_title'])) {
        $exploreTitle = $parameters['explore_proj_title'];
    }

    if (isset($parameters['explore_proj_text'])) {
        $exploreText = $parameters['explore_proj_text'];
    }

    if (isset($parameters['interested_title'])) {
        $interestedTitle = $parameters['interested_title'];
    }

    if (isset($parameters['interested_text'])) {
        $interestedText = $parameters['interested_text'];
    }

    if (isset($parameters['volonteer_link'])) {
        $volonteerNowLink = $parameters['volonteer_link'];
    }

    if (isset($parameters['proj_img1'])) {
        $projImg1 = $parameters['proj_img1'];
    }

    if (isset($parameters['proj_text1'])) {
        $projText1 = $parameters['proj_text1'];
    }

    if (isset($parameters['proj_img2'])) {
        $projImg2 = $parameters['proj_img2'];
    }

    if (isset($parameters['proj_text2'])) {
        $projText2 = $parameters['proj_text2'];
    }

    if (isset($parameters['widget_html'])) {
        $widgetHtml = $parameters['widget_html'];
    }

@endphp

<div class="form-group">
    <label>Main title:</label>
    <input class="form-control" name="parameters[main_title]" placeholder="Volunteer & help empower communities. - example"
        value="{{ $mainTitle }}" />
</div>

<div class="form-group">
    <label>Main image:</label>
    <input class="form-control" name="parameters[main_image]" placeholder="img/content/Volunteer1.jpg - example"
        value="{{ $mainImage }}" />
</div>

<div class="form-group">
    <label>Latest mission text:</label>
    <input class="form-control" name="parameters[latest_mission_text]" placeholder="TANZANIA - example"
        value="{{ $latestMissionText }}" />
</div>

<div class="form-group">
    <label>Latest mission date:</label>
    <input class="form-control" name="parameters[latest_mission_date]" placeholder="2OTH AUGUST 2020 - example"
        value="{{ $latestMissionDate }}" />
</div>

<div class="form-group">
    <label>Apply now link:</label>
    <input class="form-control" name="parameters[apply_link]" placeholder="Link here ..." value="{{ $applyLink }}" />
</div>

<div class="form-group">
    <label>Column 1 title:</label>
    <input class="form-control" name="parameters[column1_title]" placeholder="BE PART OF CHANGE - example"
        value="{{ $colTitle1 }}" />
</div>

<div class="form-group">
    <label>Column 1 text:</label>
    <input class="form-control" name="parameters[column1_text]" placeholder="Text here ..."
        value="{{ $colText1 }}" />
</div>

<div class="form-group">
    <label>Column 2 title:</label>
    <input class="form-control" name="parameters[column2_title]" placeholder="USE YOUR SKILLS - example"
        value="{{ $colTitle2 }}" />
</div>

<div class="form-group">
    <label>Column 2 text:</label>
    <input class="form-control" name="parameters[column2_text]" placeholder="Text here ..."
        value="{{ $colText2 }}" />
</div>

<div class="form-group">
    <label>Column 3 title:</label>
    <input class="form-control" name="parameters[column3_title]" placeholder="MAKE A DIFFERENCE - example"
        value="{{ $colTitle3 }}" />
</div>

<div class="form-group">
    <label>Column 3 text:</label>
    <input class="form-control" name="parameters[column3_text]" placeholder="Text here ..."
        value="{{ $colText3 }}" />
</div>

<div class="form-group">
    <label>Widget block title:</label>
    <input class="form-control" name="parameters[explore_proj_title]" placeholder="Explore past projects - example"
        value="{{ $exploreTitle }}" />
</div>

<div class="form-group">
    <label>Past project image 1:</label>
    <input class="form-control" name="parameters[proj_img1]"
        placeholder="img/content/explore-past-missions3.jpg - example" value="{{ $projImg1 }}" />
</div>

<div class="form-group">
    <label>Past project image 2:</label>
    <input class="form-control" name="parameters[proj_img2]"
        placeholder="img/content/explore-past-missions4.jpg - example" value="{{ $projImg2 }}" />
</div>

<div class="form-group">
    <label for="widget_html">Widget content:</label>
    <textarea wysiwyg-editor id="widget_html" class="form-control" name="parameters[widget_html]"
        placeholder="Insert widget content here">{{ $widgetHtml }}</textarea>
</div>


@include('modules.admin.mission_possible')

@include('modules.admin.related_topics_project')

@include('modules.admin.join_the_cause_subscribe')

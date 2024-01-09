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
    $medicNeeds = '';
    $donateNow = '';

    if (isset($parameters['donate_now'])) {
        $donateNow = $parameters['donate_now'];
    }

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

    if (isset($parameters['column3_title'])) {
        $colTitle3 = $parameters['column3_title'];
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

    if (isset($parameters['medic_needs'])) {
        $medicNeeds = $parameters['medic_needs'];
    }

    $feedbackText = '';
    if (isset($parameters['feedback_text'])) {
        $feedbackText = $parameters['feedback_text'];
    }

    $feedbackTitle = '';
    if (isset($parameters['feedback_title'])) {
        $feedbackTitle = $parameters['feedback_title'];
    }

    $feedbackVideoWidget = '';
    if (isset($parameters['feedback_video_widget'])) {
        $feedbackVideoWidget = $parameters['feedback_video_widget'];
    }

    $applyText = '';
    $sideBlockTitle1 = '';
    $sideBlockText1 = '';
    $sideBlockTitle2 = '';
    $sideBlockText2 = '';
    $sideBlockTitle3 = '';
    $sideBlockText3 = '';

    if (isset($parameters['apply_text'])) {
        $applyText = $parameters['apply_text'];
    }

    if (isset($parameters['explore_info_title_1'])) {
        $sideBlockTitle1 = $parameters['explore_info_title_1'];
    }

    if (isset($parameters['explore_info_text_1'])) {
        $sideBlockText1 = $parameters['explore_info_text_1'];
    }
    if (isset($parameters['explore_info_title_2'])) {
        $sideBlockTitle2 = $parameters['explore_info_title_2'];
    }

    if (isset($parameters['explore_info_text_2'])) {
        $sideBlockText2 = $parameters['explore_info_text_2'];
    }
    if (isset($parameters['explore_info_title_3'])) {
        $sideBlockTitle3 = $parameters['explore_info_title_3'];
    }

    if (isset($parameters['explore_info_text_3'])) {
        $sideBlockText3 = $parameters['explore_info_text_3'];
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
    <label>Header banner button link:</label>
    <input class="form-control" name="parameters[apply_link]" placeholder="Link here ..." value="{{ $applyLink }}" />
</div>

<div class="form-group">
    <label>Header banner button text:</label>
    <input class="form-control" name="parameters[apply_text]" placeholder="Text here ..." value="{{ $applyText }}" />
</div>

<div class="form-group">
    <label for="widget_html">Medic needs content:</label>
    <textarea wysiwyg-editor id="medic_needs" class="form-control" name="parameters[medic_needs]"
              placeholder="Insert Medic needs content here">{{ $medicNeeds }}</textarea>
</div>

<div class="form-group">
    <label>Feedback block title:</label>
    <input class="form-control" name="parameters[feedback_title]" placeholder="Title here ..." value="{{ $feedbackTitle }}" />
</div>

<div class="form-group">
    <label for="widget_html">Feedback content:</label>
    <textarea wysiwyg-editor id="feedback_text" class="form-control" name="parameters[feedback_text]"
              placeholder="Insert widget content here">{{ $feedbackText }}</textarea>
</div>

<div class="form-group">
    <label>Donate now link:</label>
    <input class="form-control" name="parameters[donate_now]" placeholder="Link here ..." value="{{ $donateNow }}" />
</div>

<div class="form-group">
    <label for="widget_html">Feedback video widget:</label>
    <textarea wysiwyg-editor id="feedback_video_widget" class="form-control" name="parameters[feedback_video_widget]"
              placeholder="Insert widget content here">{{ $feedbackVideoWidget }}</textarea>
</div>

<div class="form-group">
    <label for="widget_html">Widget content:</label>
    <textarea wysiwyg-editor id="widget_html" class="form-control" name="parameters[widget_html]"
              placeholder="Insert widget content here">{{ $widgetHtml }}</textarea>
</div>


@include('modules.admin.mission_possible')

@include('modules.admin.related_topics_project')

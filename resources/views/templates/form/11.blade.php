@php

    $mainTitle = "";
    $mainImage = "";
    $colTitle1 = "";
    $colText1 = "";
    $colTitle2 = "";
    $colText2 = "";
    $colTitle3 = "";
    $colText3 = "";
    $exploreTitle = "";
    $exploreText = "";
    $interestedTitle = "";
    $interestedText = "";
    $volonteerNowLink = "";

    if (isset($parameters['main_title'])) {
        $mainTitle = $parameters['main_title'];    
    }

    if (isset($parameters['main_image'])) {
        $mainImage = $parameters['main_image'];    
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
  
@endphp

<div class="form-group">
    <label>Main title:</label>
    <input class="form-control"  name="parameters[main_title]" placeholder="Volunteer & help empower communities. - example" value="{{ $mainTitle }}" />
</div>

<div class="form-group">
    <label>Main image:</label>
    <input class="form-control"  name="parameters[main_image]" placeholder="img/content/Volunteer1.jpg - example" value="{{ $mainImage }}" />
</div>

<div class="form-group">
    <label>Column 1 title:</label>
    <input class="form-control"  name="parameters[column1_title]" placeholder="BE PART OF CHANGE - example" value="{{ $colTitle1 }}" />
</div>

<div class="form-group">
    <label>Column 1 text:</label>
    <input class="form-control"  name="parameters[column1_text]" placeholder="Text here ..." value="{{ $colText1 }}" />
</div>

<div class="form-group">
    <label>Column 2 title:</label>
    <input class="form-control"  name="parameters[column2_title]" placeholder="USE YOUR SKILLS - example" value="{{ $colTitle2 }}" />
</div>

<div class="form-group">
    <label>Column 2 text:</label>
    <input class="form-control"  name="parameters[column2_text]" placeholder="Text here ..." value="{{ $colText2 }}" />
</div>

<div class="form-group">
    <label>Column 3 title:</label>
    <input class="form-control"  name="parameters[column3_title]" placeholder="MAKE A DIFFERENCE - example" value="{{ $colTitle3 }}" />
</div>

<div class="form-group">
    <label>Column 3 text:</label>
    <input class="form-control"  name="parameters[column3_text]" placeholder="Text here ..." value="{{ $colText3 }}" />
</div>

<div class="form-group">
    <label>Explore projects title:</label>
    <input class="form-control"  name="parameters[explore_proj_title]" placeholder="Explore past projects - example" value="{{ $exploreTitle }}" />
</div>

<div class="form-group">
    <label>Explore projects text:</label>
    <input class="form-control"  name="parameters[explore_proj_text]" placeholder="Text here ..." value="{{ $exploreText }}" />
</div>

<div class="form-group">
    <label>Interested title:</label>
    <input class="form-control"  name="parameters[interested_title]" placeholder="Interested? Volunteer today - example" value="{{ $interestedTitle }}" />
</div>

<div class="form-group">
    <label>Interested text:</label>
    <input class="form-control"  name="parameters[interested_text]" placeholder="Text here ..." value="{{ $interestedText }}" />
</div>

<div class="form-group">
    <label>Volonteer now link:</label>
    <input class="form-control"  name="parameters[volonteer_link]" placeholder="link here ..." value="{{ $volonteerNowLink }}" />
</div>

@include('modules.admin.mission_possible')

@include('modules.admin.related_pages')

@include('modules.admin.join_the_cause_subscribe')
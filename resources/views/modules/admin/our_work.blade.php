@php

    $ourWorkTitle = "";
    $ourWorkLink = "";

    $longtermTitle = "";
    $longtermText = "";
    $longtermVideo = "";
    $longtermVideoPreview = "";

    $emergencyTitle = "";
    $emergencyText = "";
    $emergencyVideo = "";
    $emergencyVideoPreview = "";

    $volunteeringTitle = "";
    $volunteeringText = "";
    $volunteeringVideo = "";
    $volunteeringVideoPreview = "";

    $sadiqahTitle = "";
    $sadiqahText = "";
    $sadiqahVideo = "";
    $sadiqahVideoPreview = "";


    if (isset($parameters['our_work_block_title'])) {
        $ourWorkTitle = $parameters['our_work_block_title'];
    }

    if (isset($parameters['our_work_block_link'])) {
        $ourWorkLink = $parameters['our_work_block_link'];
    }

    if (isset($parameters['our_work_longterm_title'])) {
        $longtermTitle = $parameters['our_work_longterm_title'];
    }

    if (isset($parameters['our_work_longterm_text'])) {
        $longtermText = $parameters['our_work_longterm_text'];
    }

    if (isset($parameters['our_work_longterm_video'])) {
        $longtermVideo = $parameters['our_work_longterm_video'];
    }

    if (isset($parameters['our_work_longterm_video_preview'])) {
        $longtermVideoPreview = $parameters['our_work_longterm_video_preview'];
    }

    if (isset($parameters['our_work_emergency_title'])) {
        $emergencyTitle = $parameters['our_work_emergency_title'];
    }

    if (isset($parameters['our_work_emergency_text'])) {
        $emergencyText = $parameters['our_work_emergency_text'];
    }

    if (isset($parameters['our_work_emergency_video'])) {
        $emergencyVideo = $parameters['our_work_emergency_video'];
    }

    if (isset($parameters['our_work_emergency_video_preview'])) {
        $emergencyVideoPreview = $parameters['our_work_emergency_video_preview'];
    }

    if (isset($parameters['our_work_volunteering_title'])) {
        $volunteeringTitle = $parameters['our_work_volunteering_title'];
    }

    if (isset($parameters['our_work_volunteering_text'])) {
        $volunteeringText = $parameters['our_work_volunteering_text'];
    }

    if (isset($parameters['our_work_volunteering_video'])) {
        $volunteeringVideo = $parameters['our_work_volunteering_video'];
    }

    if (isset($parameters['our_work_volunteering_video_preview'])) {
        $volunteeringVideoPreview = $parameters['our_work_volunteering_video_preview'];
    }

    if (isset($parameters['our_work_sadiqah_title'])) {
        $sadiqahTitle = $parameters['our_work_sadiqah_title'];
    }

    if (isset($parameters['our_work_sadiqah_text'])) {
        $sadiqahText = $parameters['our_work_sadiqah_text'];
    }

    if (isset($parameters['our_work_sadiqah_video'])) {
        $sadiqahVideo = $parameters['our_work_sadiqah_video'];
    }

    if (isset($parameters['our_work_sadiqah_video_preview'])) {
        $sadiqahVideoPreview = $parameters['our_work_sadiqah_video_preview'];
    }

@endphp
<div class="col-12 pb-lg-3">
    <h3 class="text-center">Our work module:</h3>
</div>

<div class="form-group col-12 col-lg-6">
    <label>Our work block title:</label>
    <input class="form-control" name="parameters[our_work_block_title]" placeholder="Our work block title"
           value="{{ $ourWorkTitle }}"/>
</div>

<div class="form-group col-12 col-lg-6">
    <label>Our work block link:</label>
    <input class="form-control" name="parameters[our_work_block_link]" placeholder="Our work block link"
           value="{{ $ourWorkLink }}"/>
</div>

<div class="col-12 col-lg-6 mt-lg-4">
    <div class="form-group">
        <label>Longterm projects title:</label>
        <input class="form-control" name="parameters[our_work_longterm_title]" placeholder="Longterm projects title"
               value="{{ $longtermTitle }}"/>
    </div>

    <div class="form-group">
        <label>Longterm projects text:</label>
        <textarea class="form-control" name="parameters[our_work_longterm_text]"
                  placeholder="Longterm projects text">{{ $longtermText }}</textarea>
    </div>

    <div class="form-group">
        <label>Longterm projects video:</label>
        <input class="form-control" name="parameters[our_work_longterm_video]" placeholder="Longterm projects video link"
               value="{{ $longtermVideo }}"/>
    </div>

    <div class="form-group">
        <label>Longterm projects video preview:</label>
        <input class="form-control" name="parameters[our_work_longterm_video_preview]" placeholder="" value="{{ $longtermVideoPreview }}">
    </div>
</div>

<div class="col-12 col-lg-6 mt-lg-4">
    <div class="form-group ">
        <label>Emergency relief title:</label>
        <input class="form-control" name="parameters[our_work_emergency_title]" placeholder="Emergency relief title"
               value="{{ $emergencyTitle }}"/>
    </div>

    <div class="form-group">
        <label>Emergency relief text:</label>
        <textarea class="form-control" name="parameters[our_work_emergency_text]"
                  placeholder="Emergency relief text">{{ $emergencyText }}</textarea>
    </div>

    <div class="form-group ">
        <label>Emergency relief video link:</label>
        <input class="form-control" name="parameters[our_work_emergency_video]" placeholder="Emergency relief video link"
               value="{{ $emergencyVideo }}"/>
    </div>

    <div class="form-group">
        <label>Emergency relief video preview:</label>
        <input class="form-control" name="parameters[our_work_emergency_video_preview]" placeholder="" value="{{ $emergencyVideoPreview }}">
    </div>
</div>


<div class="col-12 col-lg-6 mt-lg-4">
    <div class="form-group ">
        <label>Volunteering title:</label>
        <input class="form-control" name="parameters[our_work_volunteering_title]" placeholder="Volunteering title"
               value="{{ $volunteeringTitle }}"/>
    </div>

    <div class="form-group">
        <label>Volunteering text:</label>
        <textarea class="form-control" name="parameters[our_work_volunteering_text]"
                  placeholder="Volunteering text">{{ $volunteeringText }}</textarea>
    </div>

    <div class="form-group ">
        <label>Volunteering video link:</label>
        <input class="form-control" name="parameters[our_work_volunteering_video]" placeholder="Volunteering video link"
               value="{{ $volunteeringVideo }}"/>
    </div>

    <div class="form-group">
        <label>Volunteering video preview:</label>
        <input class="form-control" name="parameters[our_work_volunteering_video_preview]" placeholder="" value="{{ $volunteeringVideoPreview }}">
    </div>
</div>

<div class="col-12 col-lg-6 mt-lg-4">
    <div class="form-group ">
        <label>Sadiqah title:</label>
        <input class="form-control" name="parameters[our_work_sadiqah_title]" placeholder="Sadiqah title"
               value="{{ $sadiqahTitle }}"/>
    </div>

    <div class="form-group">
        <label>Sadiqah text:</label>
        <textarea class="form-control" name="parameters[our_work_sadiqah_text]"
                  placeholder="Sadiqah text">{{ $sadiqahText }}</textarea>
    </div>

    <div class="form-group ">
        <label>Sadiqah video link:</label>
        <input class="form-control" name="parameters[our_work_sadiqah_video]" placeholder="Sadiqah video link"
               value="{{ $sadiqahVideo }}"/>
    </div>

    <div class="form-group">
        <label>Sadiqah video preview:</label>
        <input class="form-control" name="parameters[our_work_sadiqah_video_preview]" placeholder="" value="{{ $sadiqahVideoPreview }}">
    </div>
</div>

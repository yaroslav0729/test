@php

    $soWhatImg = "";
    $latestMissionText  = "";
    $latestMissionDate = "";
    $applyNowLink = "";
    $soWhatP1 = "";
    $soWhatP2 = "";

    if (isset($parameters['so_what_img'])) {
        $soWhatImg = $parameters['so_what_img'];    
    }

    if (isset($parameters['latest_mission_text'])) {
        $latestMissionText = $parameters['latest_mission_text'];    
    }

    if (isset($parameters['latest_mission_date'])) {
        $latestMissionDate = $parameters['latest_mission_date'];    
    }

    if (isset($parameters['apply_now_link'])) {
        $applyNowLink = $parameters['apply_now_link'];    
    }

    if (isset($parameters['so_what_p1'])) {
        $soWhatP1 = $parameters['so_what_p1'];    
    }

    if (isset($parameters['so_what_p2'])) {
        $soWhatP2 = $parameters['so_what_p2'];    
    }
    
@endphp

<h3 class="text-center">So what this all module:</h3>

<div class="form-group">
    <label>So what image:</label>
    <input class="form-control" name="parameters[so_what_img]" placeholder="Insert image link" value="{{ $soWhatImg }}" />
</div>

<div class="form-group">
    <label>So what paragraph 1:</label>
    <input class="form-control" name="parameters[so_what_p1]" placeholder="Insert text" value="{{ $soWhatP1 }}" />
</div>

<div class="form-group">
    <label>So what paragraph 2:</label>
    <input class="form-control" name="parameters[so_what_p2]" placeholder="Insert text" value="{{ $soWhatP2 }}" />
</div>

<div class="form-group">
    <label>Latest mission text:</label>
    <input class="form-control" name="parameters[latest_mission_text]" placeholder="Insert text" value="{{ $latestMissionText }}" />
</div>

<div class="form-group">
    <label>Latest mission date:</label>
    <input class="form-control" name="parameters[latest_mission_date]" placeholder="Insert date" value="{{ $latestMissionDate }}" />
</div>

<div class="form-group">
    <label>Apply now link:</label>
    <input class="form-control" name="parameters[apply_now_link]" placeholder="Insert link" value="{{ $applyNowLink }}" />
</div>
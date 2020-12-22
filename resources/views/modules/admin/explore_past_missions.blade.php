@php
    $exploreTitle = "";
    $exploreText = "";
    $donateLink = "";
    $projImg1 = "";
    $projImg2 = "";
    $projText1 = "";
    $projText2 = "";
    
    if (isset($parameters['exp_title'])) {
        $exploreTitle = $parameters['exp_title'];    
    }

    if (isset($parameters['exp_text'])) {
        $exploreText = $parameters['exp_text'];    
    }

    if (isset($parameters['donate_link'])) {
        $donateLink = $parameters['donate_link'];    
    }

    if (isset($parameters['proj_img1'])) {
        $projImg1 = $parameters['proj_img1'];    
    }

    if (isset($parameters['proj_img2'])) {
        $projImg2 = $parameters['proj_img2'];    
    }

    if (isset($parameters['proj_text1'])) {
        $projText1 = $parameters['proj_text1'];    
    }

    if (isset($parameters['proj_text2'])) {
        $projText2 = $parameters['proj_text2'];    
    }

@endphp

<h3 class="mt-4 mb-4">Explore past missions module:</h3>

<div class="form-group">
    <label>Explore title:</label>
    <input class="form-control" name="parameters[exp_title]" placeholder="Insert title" value="{{ $exploreTitle }}" />
</div>

<div class="form-group">
    <label>Explore text:</label>
    <input class="form-control" name="parameters[exp_text]" placeholder="Insert text" value="{{ $exploreText }}" />
</div>

<div class="form-group">
    <label>Donate link:</label>
    <input class="form-control" name="parameters[donate_link]" placeholder="Insert link" value="{{ $donateLink }}" />
</div>

<div class="form-group">
    <label>Project 1 image:</label>
    <input class="form-control" name="parameters[proj_img1]" placeholder="Insert link" value="{{ $projImg1 }}" />
</div>

<div class="form-group">
    <label>Project 1 text:</label>
    <input class="form-control" name="parameters[proj_text1]" placeholder="Insert text" value="{{ $projText1 }}" />
</div>

<div class="form-group">
    <label>Project 2 image:</label>
    <input class="form-control" name="parameters[proj_img2]" placeholder="Insert link" value="{{ $projImg2 }}" />
</div>

<div class="form-group">
    <label>Project 2 text:</label>
    <input class="form-control" name="parameters[proj_text2]" placeholder="Insert text" value="{{ $projText2 }}" />
</div>
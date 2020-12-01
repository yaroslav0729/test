@php

    $moduleTitle = "";
    $moduleText = "";

    if (isset($parameters['what_happens_title'])) {
        $moduleTitle = $parameters['what_happens_title'];    
    }

    if (isset($parameters['what_happens_text'])) {
        $moduleText = $parameters['what_happens_text'];    
    }

    $infoBlock1 = "";
    $infoBlock2 = "";
    $infoBlock3 = "";

    if (isset($parameters['what_happens_block1_title'])) {
        $infoBlock1 = $parameters['what_happens_block1_title'];    
    }

    if (isset($parameters['what_happens_block2_title'])) {
        $infoBlock2 = $parameters['what_happens_block2_title'];    
    }

    if (isset($parameters['what_happens_block3_title'])) {
        $infoBlock3 = $parameters['what_happens_block3_title'];    
    }

    $infoBlockText1 = "";
    $infoBlockText2 = "";
    $infoBlockText3 = "";

    if (isset($parameters['what_happens_block1_text'])) {
        $infoBlockText1 = $parameters['what_happens_block1_text'];    
    }

    if (isset($parameters['what_happens_block2_text'])) {
        $infoBlockText2 = $parameters['what_happens_block2_text'];    
    }

    if (isset($parameters['what_happens_block3_text'])) {
        $infoBlockText3 = $parameters['what_happens_block3_text'];    
    }

    $bgImage = "";

    if (isset($parameters['what_happens_img'])) {
        $bgImage = $parameters['what_happens_img'];    
    }

@endphp

<h3 class="text-center">What happens module:</h3>

<div class="form-group">
    <label>What happens title:</label>
    <input class="form-control" name="parameters[what_happens_title]" placeholder="Insert what happens title" value="{{ $moduleTitle }}" />
</div>

<div class="form-group">
    <label>What happens text</label>
    <textarea class="form-control" required name="parameters[what_happens_text]" placeholder="Insert what happens  text">{{ $moduleText }}</textarea>
</div>

<div class="form-group">
    <label>What happens image:</label>
    <input class="form-control" name="parameters[what_happens_img]" placeholder="Insert what happens image" value="{{ $bgImage }}" />
</div>

<div class="form-group">
    <label>What happens block1 title:</label>
    <input class="form-control" type="text" name="parameters[what_happens_block1_title]" placeholder="Insert value" value="{{ $infoBlock1 }}" />
</div>

<div class="form-group">
    <label>What happens block1 text:</label>
    <input class="form-control" type="text" name="parameters[what_happens_block1_text]" placeholder="Insert value" value="{{ $infoBlockText1 }}" />
</div>

<div class="form-group">
    <label>What happens block2 title:</label>
    <input class="form-control" type="text" name="parameters[what_happens_block2_title]" placeholder="Insert value" value="{{ $infoBlock2 }}" />
</div>

<div class="form-group">
    <label>What happens block2 text:</label>
    <input class="form-control" type="text" name="parameters[what_happens_block2_text]" placeholder="Insert value" value="{{ $infoBlockText2 }}" />
</div>

<div class="form-group">
    <label>What happens block3 title:</label>
    <input class="form-control" type="text" name="parameters[what_happens_block3_title]" placeholder="Insert value" value="{{ $infoBlock3 }}" />
</div>

<div class="form-group">
    <label>What happens block3 text:</label>
    <input class="form-control" type="text" name="parameters[what_happens_block3_text]" placeholder="Insert value" value="{{ $infoBlockText3 }}" />
</div>
@php

    $projHeading = "";

    $projPar1 = "";
    $projPar2 = "";
    $projPar3 = "";

    $projVideo = "";

    $projHeader1 = "";
    $projHeader2 = "";
    $projHeader3 = "";

    if (isset($parameters['proj_heading'])) {
        $projHeading = $parameters['proj_heading'];    
    }

    if (isset($parameters['proj_par1'])) {
        $projPar1 = $parameters['proj_par1'];    
    }

    if (isset($parameters['proj_par2'])) {
        $projPar2 = $parameters['proj_par2'];    
    }

    if (isset($parameters['proj_par3'])) {
        $projPar3 = $parameters['proj_par3'];    
    }

    if (isset($parameters['proj_hdr1'])) {
        $projHeader1 = $parameters['proj_hdr1'];    
    }

    if (isset($parameters['proj_hdr2'])) {
        $projHeader2 = $parameters['proj_hdr2'];    
    }

    if (isset($parameters['proj_hdr3'])) {
        $projHeader3 = $parameters['proj_hdr3'];    
    }

    if (isset($parameters['proj_video'])) {
        $projVideo = $parameters['proj_video'];    
    }

@endphp

<div class="form-group">
    <label>Project heading:</label>
    <input class="form-control" name="parameters[proj_heading]" placeholder="Insert project heading" value="{{ $projHeading }}" />
</div>

<div class="form-group">
    <label>Header 1:</label>
    <input class="form-control" name="parameters[proj_hdr1]" placeholder="Insert text" value="{{ $projHeader1 }}" />
</div>

<div class="form-group">
    <label>Paragraph 1:</label>
    <textarea rows="3" class="form-control" name="parameters[proj_par1]" placeholder="Insert text">{{ $projPar1 }}</textarea>
</div>

<div class="form-group">
    <label>Header 2:</label>
    <input class="form-control" name="parameters[proj_hdr2]" placeholder="Insert text" value="{{ $projHeader2 }}" />
</div>

<div class="form-group">
    <label>Paragraph 2:</label>
    <textarea rows="3" class="form-control" name="parameters[proj_par2]" placeholder="Insert text">{{ $projPar2 }}</textarea>
</div>

<div class="form-group">
    <label>Video id:</label>
    <input class="form-control" name="parameters[proj_video]" placeholder="Insert video id" value="{{ $projVideo }}" />
</div>

<div class="form-group">
    <label>Header 3:</label>
    <input class="form-control" name="parameters[proj_hdr3]" placeholder="Insert text" value="{{ $projHeader3 }}" />
</div>

<div class="form-group">
    <label>Paragraph 3:</label>
    <textarea rows="3" class="form-control" name="parameters[proj_par3]" placeholder="Insert text">{{ $projPar3 }}</textarea>
</div>

@include('modules.admin.donate_module')

@include('modules.admin.what_happens_so_far')

@include('modules.admin.we_still_need_support')

@include('modules.admin.important_information')

@include('modules.admin.related_page_expanded')
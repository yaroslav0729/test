@php
    
    $bePartTitle = "";
    $bePartText = "";
    $bePartLink = "";

    if (isset($parameters['be_part_title'])) {
        $bePartTitle = $parameters['be_part_title'];    
    }

    if (isset($parameters['be_part_text'])) {
        $bePartText = $parameters['be_part_text'];    
    }

    if (isset($parameters['be_part_link'])) {
        $bePartLink = $parameters['be_part_link'];    
    }

@endphp

<h3 class="mt-4 mb-4">Be part module:</h3>

<div class="form-group">
    <label>Be part title:</label>
    <input class="form-control" name="parameters[be_part_title]" placeholder="Insert title" value="{{ $bePartTitle }}" />
</div>

<div class="form-group">
    <label>Be part text:</label>
    <input class="form-control" name="parameters[be_part_text]" placeholder="Insert text" value="{{ $bePartText }}" />
</div>

<div class="form-group">
    <label>Be part link:</label>
    <input class="form-control" name="parameters[be_part_link]" placeholder="Insert link" value="{{ $bePartLink }}" />
</div>
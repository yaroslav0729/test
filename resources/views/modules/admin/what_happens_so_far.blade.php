@php

    $moduleTitle = "";
    $moduleText = "";

    if (isset($parameters['what_happens_title'])) {
        $moduleTitle = $parameters['what_happens_title'];    
    }

    if (isset($parameters['what_happens_text'])) {
        $moduleText = $parameters['what_happens_text'];    
    }

    $peopleHelped = "";
    $countries = "";
    $volunteers = "";

    if (isset($parameters['what_happens_people_helped'])) {
        $peopleHelped = $parameters['what_happens_people_helped'];    
    }

    if (isset($parameters['what_happens_countries'])) {
        $countries = $parameters['what_happens_countries'];    
    }

    if (isset($parameters['what_happens_volunteers'])) {
        $volunteers = $parameters['what_happens_volunteers'];    
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
    <label>What happens people helped:</label>
    <input class="form-control" type="number" name="parameters[what_happens_people_helped]" placeholder="Insert people helped quantity" value="{{ $peopleHelped }}" />
</div>

<div class="form-group">
    <label>What happens countries:</label>
    <input class="form-control" type="number" name="parameters[what_happens_countries]" placeholder="Insert countries quantity" value="{{ $countries }}" />
</div>

<div class="form-group">
    <label>What happens volunteers:</label>
    <input class="form-control" type="number" name="parameters[what_happens_volunteers]" placeholder="Insert volunteers quantity" value="{{ $volunteers }}" />
</div>
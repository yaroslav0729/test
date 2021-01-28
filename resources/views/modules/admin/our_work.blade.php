@php

    $longtermLink = "";
    $emergencyLink = "";
    $volunteeringLink = "";
    $sadiqahLink = "";

    if (isset($parameters['our_work_longterm_link'])) {
        $longtermLink = $parameters['our_work_longterm_link'];
    }

    if (isset($parameters['our_work_emergency_link'])) {
        $emergencyLink = $parameters['our_work_emergency_link'];
    }

    if (isset($parameters['our_work_volunteering_link'])) {
        $volunteeringLink = $parameters['our_work_volunteering_link'];
    }

    if (isset($parameters['our_work_sadiqah_link'])) {
        $sadiqahLink = $parameters['our_work_sadiqah_link'];
    }
    
@endphp

<h3 class="text-center">Our work module:</h3>

<div class="row col-12 mt-5">
    <div class="form-group col-12 col-lg-6">
        <label>Our work Longterm projects link:</label>
        <input class="form-control" required name="parameters[our_work_longterm_link]" placeholder="Longterm projects"
               value="{{ $longtermLink }}"/>
    </div>

    <div class="form-group col-12 col-lg-6">
        <label>Our work Emergency relief link:</label>
        <input class="form-control" required name="parameters[our_work_emergency_link]" placeholder="Emergency relief"
               value="{{ $emergencyLink }}"/>
    </div>

    <div class="form-group col-12 col-lg-6">
        <label>Our work Volunteering link:</label>
        <input class="form-control" required name="parameters[our_work_volunteering_link]"
               placeholder="Who we are title" value="{{ $volunteeringLink }}"/>
    </div>

    <div class="form-group col-12 col-lg-6">
        <label>Our work Sadiqah link:</label>
        <input class="form-control" required name="parameters[our_work_sadiqah_link]" placeholder="Who we are title"
               value="{{ $sadiqahLink }}"/>
    </div>
</div>
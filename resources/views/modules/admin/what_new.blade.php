@php

    $whatNewTitle = "";
    $visitNewsroomTitle = "";
    $visitNewsroomLink = "";

    if (isset($parameters['what_new_title'])) {
        $whatNewTitle = $parameters['what_new_title'];
    }

    if (isset($parameters['visit_newsroom_title'])) {
        $visitNewsroomTitle = $parameters['visit_newsroom_title'];
    }

    if (isset($parameters['visit_newsroom_link'])) {
        $visitNewsroomLink = $parameters['visit_newsroom_link'];
    }

@endphp

<h3 class="text-center">What's new module:</h3>

<div class="form-group">
    <label>What's new title:</label>
    <input class="form-control" name="parameters[what_new_title]" placeholder="What's new title"
           value="{{ $whatNewTitle }}"/>
</div>

<div class="form-group ">
    <label>Visit newsroom title:</label>
    <input class="form-control" name="parameters[visit_newsroom_title]" placeholder="Visit newsroom title"
           value="{{ $visitNewsroomTitle }}"/>
</div>

<div class="form-group ">
    <label>Visit newsroom link:</label>
    <input class="form-control" name="parameters[visit_newsroom_link]" placeholder="Visit newsroom link"
           value="{{ $visitNewsroomLink }}"/>
</div>

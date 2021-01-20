@php

    $donateToProjTitle = "";

    if (isset($parameters['donate_to_title'])) {
        $donateToProjTitle = $parameters['donate_to_title'];
    }

    $donateToProjText = "";

    if (isset($parameters['donate_to_text'])) {
        $donateToProjText = $parameters['donate_to_text'];
    }

@endphp

<h3 class="text-center">Related Projects module:</h3>

<div class="form-group">
    <label>Donate to project title:</label>
    <input class="form-control" required name="parameters[donate_to_title]" placeholder="Text value here" value="{{ $donateToProjTitle }}" />
</div>

<div class="form-group">
    <label>Donate to project text:</label>
    <input class="form-control" required name="parameters[donate_to_text]" placeholder="Text value here" value="{{ $donateToProjText }}" />
</div>

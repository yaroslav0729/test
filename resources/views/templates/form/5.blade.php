@php

    $mainTitle = "";

    if (isset($parameters['main_title'])) {
        $mainTitle = $parameters['main_title'];
    }

    $afterTitleText = "";

    if (isset($parameters['after_text'])) {
        $afterTitleText = $parameters['after_text'];
    }

    $donateToProjTitle = "";

    if (isset($parameters['donate_to_title'])) {
        $donateToProjTitle = $parameters['donate_to_title'];
    }

    $donateToProjText = "";

    if (isset($parameters['donate_to_text'])) {
        $donateToProjText = $parameters['donate_to_text'];
    }

@endphp

<div class="form-group">
    <label>Main title:</label>
    <input class="form-control" required name="parameters[main_title]" placeholder="Text value here" value="{{ $mainTitle }}" />
</div>

<div class="form-group">
    <label>After main title text:</label>
    <input class="form-control" required name="parameters[after_text]" placeholder="Text value here" value="{{ $afterTitleText }}" />
</div>

<div class="form-group">
    <label>Donate to project title:</label>
    <input class="form-control" required name="parameters[donate_to_title]" placeholder="Text value here" value="{{ $donateToProjTitle }}" />
</div>

<div class="form-group">
    <label>Donate to project text:</label>
    <input class="form-control" required name="parameters[donate_to_text]" placeholder="Text value here" value="{{ $donateToProjText }}" />
</div>

@include('modules.admin.donate_module', [
    'parameters' => $parameters,
    'useAppeal' => true
])

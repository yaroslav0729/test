@php

    $perPage = "";

    if (isset($parameters['per_page'])) {
        $perPage = $parameters['per_page'];
    }

@endphp

<div class="row">
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Number events per page:</label>
            <input class="form-control" required name="parameters[per_page]"
                   placeholder="Number events per page"
                   value="{{ $perPage }}"/>
        </div>
    </div>
</div>


@include('modules.admin.islamic_help_needs_you', [
    'parameters' => $parameters
])

@include('modules.admin.join_the_cause_subscribe', [
    'parameters' => $parameters
])

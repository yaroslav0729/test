@php

    $bgImage = "";
    $ourMissionTitle = "";
    $ourValuesDescription = "";
    $ourValuesVideo = "";

    for ($i=1; $i<=4; $i++){
        ${'actionName' . $i} = "";
        ${'actionPhoto' . $i} = "";
        ${'actionSlogan' . $i} = "";
        ${'actionTitle' . $i} = "";
        ${'actionDescription' . $i} = "";
        ${'actionLearnMoreLink' . $i} = "";
    }

    $lifeChangingBlockTitle = "";
    $lifeChangingBlockText = "";

    if (isset($parameters['background_image'])) {
        $bgImage = $parameters['background_image'];
    }

    if (isset($parameters['our_values_description'])) {
        $ourValuesDescription = $parameters['our_values_description'];
    }

    if (isset($parameters['our_values_video'])) {
        $ourValuesVideo = $parameters['our_values_video'];
    }

    if (isset($parameters['our_mission_title'])) {
        $ourMissionTitle = $parameters['our_mission_title'];
    }

    $actionActive = $parameters['action_active'] ?? [];

    for ($i=1; $i<=4; $i++){
        if (isset($parameters["action_name_{$i}"])) {
            ${'actionName' . $i} = $parameters["action_name_{$i}"];
        }
        if (isset($parameters["action_photo_{$i}"])) {
            ${'actionPhoto' . $i} = $parameters["action_photo_{$i}"];
        }
        if (isset($parameters["action_slogan_{$i}"])) {
            ${'actionSlogan' . $i} = $parameters["action_slogan_{$i}"];
        }
        if (isset($parameters["action_title_{$i}"])) {
            ${'actionTitle' . $i} = $parameters["action_title_{$i}"];
        }
        if (isset($parameters["action_description_{$i}"])) {
            ${'actionDescription' . $i} = $parameters["action_description_{$i}"];
        }
        if (isset($parameters["action_learn_more_link_{$i}"])) {
            ${'actionLearnMoreLink' . $i} = $parameters["action_learn_more_link_{$i}"];
        }
    }

    if (isset($parameters['changing_block_title'])) {
        $lifeChangingBlockTitle = $parameters['changing_block_title'];
    }
    if (isset($parameters['changing_block_text'])) {
        $lifeChangingBlockText = $parameters['changing_block_text'];
    }

@endphp

<div class="row">
    {{--    {{ $actionName1 }}--}}
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Background image:</label>
            <input class="form-control " required name="parameters[background_image]"
                   placeholder="Insert background image path"
                   value="{{ $bgImage }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Our mission title:</label>
            <input class="form-control " required name="parameters[our_mission_title]" placeholder="Our mission title"
                   value="{{ $ourMissionTitle }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Our values description:</label>
            {{--            <input class="form-control" required name="parameters[our_values_description]"
                               placeholder="Our values description"
                               value="{{ $ourValuesDescription }}"/>--}}
            <textarea class="form-control" required name="parameters[our_values_description]"
                      placeholder="Our values description">{{ $ourValuesDescription }}</textarea>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Our values video:</label>
            <input class="form-control" required name="parameters[our_values_video]"
                   placeholder="Insert youtube video link"
                   value="{{ $ourValuesVideo }}"/>
        </div>
    </div>
</div>
<div class="form-group">
    <label>Our values in Action:</label>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            @for ($i = 1; $i <= 4; $i++)
                <a class="nav-item nav-link @if($i === 1)active @endif" id="nav-action-tab-{{ $i }}" data-toggle="tab"
                   href="#nav-action-{{ $i }}"
                   role="tab" aria-controls="nav-home" aria-selected="true">Block-{{ $i }}</a>
            @endfor
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        @for ($i = 1; $i <= 4; $i++)

            <div class="tab-pane fade show @if($i === 1)active @endif" id="nav-action-{{ $i }}" role="tabpanel"
                 aria-labelledby="nav-home-tab">
                <div class="row mt-3">

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" name="parameters[action_active][]" type="checkbox"
                                   value="{{ $i }}" id="defaultCheck{{ $i }}"
                                   @if(in_array($i, $actionActive ))checked @endif>
                            <label class="form-check-label" for="defaultCheck{{ $i }}">
                                Active block
                            </label>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 mt-2">
                        <div class="form-group">
                            <label>Name:</label>
                            <input class="form-control" required name="parameters[action_name_{{ $i }}]"
                                   placeholder="Name"
                                   value="{!! ${'actionName' . $i} !!}"/>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>Photo:</label>
                            <input class="form-control" required name="parameters[action_photo_{{ $i }}]"
                                   placeholder="Insert photo path"
                                   value="{!! ${'actionPhoto' . $i} !!}"/>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>Slogan:</label>
                            <input class="form-control " required name="parameters[action_slogan_{{ $i }}]"
                                   placeholder="Slogan"
                                   value="{!! ${'actionSlogan' . $i} !!}"/>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>Title:</label>
                            <input class="form-control " required name="parameters[action_title_{{ $i }}]"
                                   placeholder="Title"
                                   value="{!! ${'actionTitle' . $i} !!}"/>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>Description:</label>
                            <textarea class="form-control" required name="parameters[action_description_{{ $i }}]"
                                      placeholder="Description">{!! ${'actionDescription' . $i} !!}</textarea>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>Learn more link:</label>
                            <input class="form-control" required name="parameters[action_learn_more_link_{{ $i }}]"
                                   placeholder="Learn more link"
                                   value="{!! ${'actionLearnMoreLink' . $i} !!}"/>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>
<div class="row">
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Life changing support title:</label>
            <input class="form-control " required name="parameters[changing_block_title]"
                   placeholder="Life changing support title"
                   value="{{ $lifeChangingBlockTitle }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Life changing support text:</label>
            <textarea class="form-control" required name="parameters[changing_block_text]"
                      placeholder="Life changing support text">{!! $lifeChangingBlockText !!}</textarea>
        </div>
    </div>
</div>




@php

    $bgImage = "";
    $ourMissionTitle = "";
    $ourValuesDescription = "";
    $ourValuesVideo = "";

    $actionFirstItemName = "";
    $actionFirstItemPhoto = "";
    $actionFirstItemSlogan = "";
    $actionFirstItemTitle = "";
    $actionFirstItemDescription = "";
    $actionFirstItemLearnMoreLink = "";

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
/*    $actionName1 = 3;
    $actionName2 = 3;
    $actionName3 = 3;
    $actionName4 = 3;*/

    for ($i=1; $i<=4; $i++){
        if (isset($parameters["action_name_{$i}"])) {
            ${'actionName' . $i} = $parameters["action_name_{$i}"];
        }


/*        if (isset($parameters['action_first_photo . $i .'])) {
            ${'actionPhoto' . $i} = $parameters['action_photo. $i .'];
        }

        if (isset($parameters['action_first_slogan . $i .'])) {
            ${'actionSlogan' . $i} = $parameters['action_slogan. $i .'];
        }

        if (isset($parameters['action_first_title. $i .'])) {
            ${'actionTitle' . $i} = $parameters['action_title. $i .'];
        }

        if (isset($parameters['action_first_description. $i .'])) {
            ${'actionDescription' . $i} = $parameters['action_description. $i .'];
        }

        if (isset($parameters['action_first_learn_more_link. $i .'])) {
            ${'actionLearnMoreLink' . $i} = $parameters['action_learn_more_link. $i .'];
        }*/
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
            <a class="nav-item nav-link @if($i === 1)active @endif" id="nav-action-tab-{{ $i }}" data-toggle="tab" href="#nav-action-{{ $i }}"
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
                                   value="{{ $i }}" id="defaultCheck{{ $i }}">
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
                                   value="{{ ${'actionName' . $i}  }}"/>
                        </div>
                    </div>
{{--
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>Photo:</label>
                            <input class="form-control" required name="parameters[action_photo_{{ $i }}]"
                                   placeholder="Insert photo path"
                                   value="{{ $actionPhoto . $i }}"/>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>Slogan:</label>
                            <input class="form-control " required name="parameters[action_slogan_{{ $i }}]"
                                   placeholder="Slogan"
                                   value="{{ $actionSlogan . $i }}"/>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>Title:</label>
                            <input class="form-control " required name="parameters[action_title_{{ $i }}]"
                                   placeholder="Title"
                                   value="{{ $actionTitle . $i }}"/>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>Description:</label>
                            <textarea class="form-control" required name="parameters[action_description_{{ $i }}]"
                                      placeholder="Description">{{ $actionDescription . $i }}</textarea>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>Learn more link:</label>
                            <input class="form-control" required name="parameters[action_learn_more_link_{{ $i }}]"
                                   placeholder="Learn more link"
                                   value="{{ $actionLearnMoreLink . $i }}"/>
                        </div>
                    </div>
--}}

                </div>
            </div>
        @endfor
    </div>
</div>


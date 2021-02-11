@php

    $bgImage = "";
    $ourMissionTitle = "";
    $ourValuesDescription = "";
    $ourValuesInActionDescription = "";
    $ourValuesVideo = "";
    $mapImage = "";
    $mapAlternativeImage = "";
    $hdrColorType = "";

    $storyActive = $parameters['story_active'] ?? [];

    for ($i=1; $i<=4; $i++) {
        $actionActive[$i] = "";
        $actionName[$i] = "";
        $actionPhoto[$i] = "";
        $actionSlogan[$i] = "";
        $actionTitle[$i] = "";
        $actionDescription[$i] = "";
        $actionLearnMoreLink[$i] = "";
    }

    for ($i=1; $i<=3; $i++){
        ${'storyPhoto' . $i} = "";
        ${'storyYear' . $i} = "";
        ${'storyText' . $i} = "";
    }

    for ($i=1; $i<=2; $i++){
        ${'lifeChangingPhoto' . $i} = "";
        ${'lifeChangingPhrase' . $i} = "";
    }

    $lifeChangingBlockTitle = "";
    $lifeChangingBlockText = "";
    $lifeChangingBlockTextMobile = "";

    if (isset($parameters['hdr_color_type'])) {
        $hdrColorType = $parameters['hdr_color_type'];
    }

    if (isset($parameters['background_image'])) {
        $bgImage = $parameters['background_image'];
    }

    if (isset($parameters['our_mission_title'])) {
        $ourMissionTitle = $parameters['our_mission_title'];
    }

    if (isset($parameters['our_values_description'])) {
        $ourValuesDescription = $parameters['our_values_description'];
    }

    if (isset($parameters['our_values_video'])) {
        $ourValuesVideo = $parameters['our_values_video'];
    }

    if (isset($parameters['map_image'])) {
        $mapImage = $parameters['map_image'];
    }

    if (isset($parameters['map_alt_image'])) {
        $mapAlternativeImage = $parameters['map_alt_image'];
    }

    if (isset($parameters['our_values_action_description'])) {
        $ourValuesInActionDescription = $parameters['our_values_action_description'];
    }

    /* $actionActive = $parameters['action_active'] ?? [];*/

    for ($i=1; $i<=4; $i++){
        if (isset($parameters['action_active_' . $i])) {
            $actionActive[$i] = $parameters['action_active_' . $i];
        }
        if (isset($parameters['action_name_' . $i])) {
            $actionName[$i] = $parameters['action_name_' . $i];
        }
        if (isset($parameters['action_photo_' .$i])) {
            $actionPhoto[$i] = $parameters['action_photo_' . $i];
        }
        if (isset($parameters['action_slogan_' .$i])) {
            $actionSlogan[$i] = $parameters['action_slogan_' . $i];
        }
        if (isset($parameters['action_title_' .$i])) {
            $actionTitle[$i] = $parameters['action_title_' . $i];
        }
        if (isset($parameters['action_description_' .$i])) {
            $actionDescription[$i] = $parameters['action_description_' . $i];
        }
        if (isset($parameters['action_learn_more_link_' .$i])) {
            $actionLearnMoreLink[$i] = $parameters['action_learn_more_link_' . $i];
        }
    }

    for ($i=1; $i<=3; $i++){
        if (isset($parameters["story_year_{$i}"])) {
            ${'storyYear' . $i} = $parameters["story_year_{$i}"];
        }
        if (isset($parameters["story_photo_{$i}"])) {
            ${'storyPhoto' . $i} = $parameters["story_photo_{$i}"];
        }
        if (isset($parameters["story_text_{$i}"])) {
            ${'storyText' . $i} = $parameters["story_text_{$i}"];
        }
    }

    for ($i=1; $i<=2; $i++){
        if (isset($parameters["changing_block_photo_{$i}"])) {
            ${'lifeChangingPhoto' . $i} = $parameters["changing_block_photo_{$i}"];
        }
        if (isset($parameters["changing_block_phrase_{$i}"])) {
            ${'lifeChangingPhrase' . $i} = $parameters["changing_block_phrase_{$i}"];
        }
    }

    $changingActive = $parameters['changing_active'] ?? [];

    if (isset($parameters['changing_block_title'])) {
        $lifeChangingBlockTitle = $parameters['changing_block_title'];
    }

    if (isset($parameters['changing_block_text'])) {
        $lifeChangingBlockText = $parameters['changing_block_text'];
    }

    if (isset($parameters['changing_block_text_mobile'])) {
        $lifeChangingBlockTextMobile = $parameters['changing_block_text_mobile'];
    }

@endphp

<div class="row">
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Background image:</label>
            <input class="form-control" name="parameters[background_image]"
                   placeholder="Insert background image path"
                   value="{{ $bgImage }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Our mission title:</label>
            <input class="form-control" name="parameters[our_mission_title]" placeholder="Our mission title"
                   value="{{ $ourMissionTitle }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6 mt-5">
        <div class="form-group">
            <label>Our values description:</label>
            <textarea class="form-control" name="parameters[our_values_description]"
                      placeholder="Our values description">{{ $ourValuesDescription }}</textarea>
        </div>
    </div>

    <div class="col-12 col-lg-6 mt-5">
        <div class="form-group">
            <label>Our values video:</label>
            <input class="form-control" name="parameters[our_values_video]"
                   placeholder="Insert youtube video link"
                   value="{{ $ourValuesVideo }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Map image path:</label>
            <input class="form-control" name="parameters[map_image]"
                   placeholder="Insert map image path"
                   value="{{ $mapImage }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Map alternative image path:</label>
            <input class="form-control" name="parameters[map_alt_image]"
                   placeholder="Insert map alternative image path"
                   value="{{ $mapAlternativeImage }}"/>
        </div>
    </div>
</div>

<div class="form-group mt-5">
    <label class="font-weight-bold">Our values in Action:</label>
    <div class="mt-2">
        <div class="form-group">
            <label>Our values in action description (for mobile):</label>
            <textarea class="form-control" name="parameters[our_values_action_description]"
                      placeholder="Our values in action description (for mobile)">{{ $ourValuesInActionDescription }}</textarea>
        </div>
    </div>

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            @for ($i = 1; $i <= 4; $i++)
                <a class="nav-item nav-link @if($i === 1)active @endif" id="nav-action-tab-{{ $i }}" data-toggle="tab"
                   href="#nav-action-{{ $i }}"
                   role="tab" aria-controls="nav-home" aria-selected="true">Slide {{ $i }}</a>
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
                            <input class="form-check-input" name="parameters[action_active_{{ $i }}]" type="checkbox"
                                   value="{{ $i }}" id="defaultCheck{{ $i }}"
                                   @if(in_array($i, $actionActive ))checked @endif>
                            <label class="form-check-label" for="defaultCheck{{ $i }}">
                                Active slide
                            </label>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 mt-2">
                        <div class="form-group">
                            <label>Name:</label>
                            <input class="form-control" name="parameters[action_name_{{ $i }}]"
                                   placeholder="Name"
                                   value="{!! $actionName[$i] !!}"/>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>Photo:</label>
                            <input class="form-control" name="parameters[action_photo_{{ $i }}]"
                                   placeholder="Insert photo path"
                                   value="{!! $actionPhoto[$i] !!}"/>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>Slogan:</label>
                            <input class="form-control " name="parameters[action_slogan_{{ $i }}]"
                                   placeholder="Slogan"
                                   value="{!! $actionSlogan[$i] !!}"/>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>Title:</label>
                            <input class="form-control " name="parameters[action_title_{{ $i }}]"
                                   placeholder="Title"
                                   value="{!! $actionTitle[$i] !!}"/>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>Description:</label>
                            <textarea class="form-control" name="parameters[action_description_{{ $i }}]"
                                      placeholder="Description">{!! $actionDescription[$i] !!}</textarea>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>Learn more link:</label>
                            <input class="form-control" name="parameters[action_learn_more_link_{{ $i }}]"
                                   placeholder="Learn more link"
                                   value="{!! $actionLearnMoreLink[$i] !!}"/>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>

<div class="form-group mt-5">
    <label class="font-weight-bold">Our story:</label>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            @for ($i = 1; $i <= 3; $i++)
                <a class="nav-item nav-link @if($i === 1)active @endif" id="nav-action-tab-{{ $i }}" data-toggle="tab"
                   href="#nav-story-{{ $i }}"
                   role="tab" aria-controls="nav-home" aria-selected="true">Slide {{ $i }}</a>
            @endfor
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        @for ($i = 1; $i <= 3; $i++)
            <div class="tab-pane fade show @if($i === 1)active @endif" id="nav-story-{{ $i }}" role="tabpanel"
                 aria-labelledby="nav-home-tab">
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" name="parameters[story_active][]" type="checkbox"
                                   value="{{ $i }}" id="defaultCheck{{ $i }}"
                                   @if(in_array($i, $storyActive ))checked @endif>
                            <label class="form-check-label" for="defaultCheck{{ $i }}">
                                Active slide
                            </label>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 mt-2">
                        <div class="form-group">
                            <label>Year:</label>
                            <input class="form-control" name="parameters[story_year_{{ $i }}]"
                                   placeholder="Year"
                                   value="{!! ${'storyYear' . $i} !!}"/>
                        </div>
                        <div class="form-group">
                            <label>Photo:</label>
                            <input class="form-control" name="parameters[story_photo_{{ $i }}]"
                                   placeholder="Insert photo path"
                                   value="{!! ${'storyPhoto' . $i} !!}"/>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 mt-2">
                        <div class="form-group">
                            <label>Text:</label>
                            <textarea class="form-control" rows="3" name="parameters[story_text_{{ $i }}]"
                                      placeholder="Life changing support text">{!! ${'storyText' . $i} !!}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>

<div class="row mt-5">
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Life changing support title:</label>
            <input class="form-control" name="parameters[changing_block_title]"
                   placeholder="Life changing support title"
                   value="{{ $lifeChangingBlockTitle }}"/>
        </div>
    </div>

    <div class="form-group col-12 col-lg-6">
        <label>Header color style</label>
        <select name="parameters[hdr_color_type]" class="form-control">
            <option value="blue" @if(($hdrColorType) === 'blue') selected @endif>Blue</option>
            <option value="red" @if(($hdrColorType) === 'red') selected @endif>Red</option>
        </select>
    </div>
    @for ($i = 1; $i <= 2; $i++)
        <div class="col-12 col-lg-6 mt-2">
            <div class="form-check">
                <input class="form-check-input" name="parameters[changing_active][]" type="checkbox"
                       value="{{ $i }}" id="defaultCheck{{ $i }}"
                       @if(in_array($i, $changingActive ))checked @endif>
                <label class="form-check-label" for="defaultCheck{{ $i }}">
                    Active slide {{ $i }}
                </label>
            </div>
            <div class="form-group mt-2">
                <label>Photo:</label>
                <input class="form-control" name="parameters[changing_block_photo_{{ $i }}]"
                       placeholder="Insert photo path"
                       value="{!! ${'lifeChangingPhoto' . $i} !!}"/>
            </div>
            <div class="form-group">
                <label>Phrase:</label>
                <input class="form-control" name="parameters[changing_block_phrase_{{ $i }}]"
                       placeholder="Phrase"
                       value="{!! ${'lifeChangingPhrase' . $i} !!}"/>
            </div>
        </div>
    @endfor

    <div class="col-12 mt-3">
        <div class="form-group">
            <label>Life changing support text:</label>
            <textarea wysiwyg-editor id="main_html" class="form-control" name="parameters[changing_block_text]"
                      placeholder="Life changing support text">{{ $lifeChangingBlockText }}</textarea>
        </div>

        <div class="form-group">
            <label>Life changing support text (for mobile - max 460ch ):</label>
            <textarea class="form-control" rows="3" name="parameters[changing_block_text_mobile]"
                      placeholder="Life changing support text (mobile)">{{ $lifeChangingBlockTextMobile }}</textarea>
        </div>
    </div>


</div>

<div class="row mt-5">
    <div class="col-12">
        @include('modules.admin.related_page_expanded', [
            'parameters' => $parameters
        ])
    </div>
</div>

<div class="row mt-5">
    <div class="col-12">
        @include('modules.admin.join_the_cause_subscribe', [
            'parameters' => $parameters
        ])
    </div>
</div>


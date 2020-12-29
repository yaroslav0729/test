@php

    $whoVideo = "";
    $whoLink = "";
    $whoLinkText = "";
    $whoTitle = "";
    $whoText = "";
    $longtermLink = "";
    $emergencyLink = "";
    $volunteeringLink = "";
    $sadiqahLink = "";

    $hdrTypeActive = [];
    $hdrColorType = "";
    $hdrLinkText = [];
    $hdrLearnMoreLink = [];
    $hdrTitle = [];
    $hdrText = [];
    $hdrBgImage = [];

    for ($i=1; $i<=4; $i++) {
        $hdrTypeActive[$i] = "";
        $hdrLinkText[$i] = "";
        $hdrLearnMoreLink[$i] = "";
        $hdrTitle[$i] = "";
        $hdrText[$i] = "";
        $hdrBgImage[$i] = "";
    }

    if (isset($parameters['hdr_color_type'])) {
        $hdrColorType = $parameters['hdr_color_type'];
    }

    for ($i=1; $i<=4; $i++){
        if (isset($parameters['hdr_type_active_' . $i])) {
            $hdrTypeActive[$i] = $parameters['hdr_type_active_' . $i];
        }
        if (isset($parameters['hdr_link_text_' . $i])) {
            $hdrLinkText[$i] = $parameters['hdr_link_text_' . $i];
        }
        if (isset($parameters['hdr_learn_more_link_' .$i])) {
            $hdrLearnMoreLink[$i] = $parameters['hdr_learn_more_link_' . $i];
        }
        if (isset($parameters['hdr_title_' .$i])) {
            $hdrTitle[$i] = $parameters['hdr_title_' . $i];
        }
        if (isset($parameters['hdr_text_' .$i])) {
            $hdrText[$i] = $parameters['hdr_text_' . $i];
        }
        if (isset($parameters['hdr_bg_image_' .$i])) {
            $hdrBgImage[$i] = $parameters['hdr_bg_image_' . $i];
        }
    }


    if (isset($parameters['who_we_are_video'])) {
        $whoVideo = $parameters['who_we_are_video'];
    }

    if (isset($parameters['who_we_are_link'])) {
        $whoLink = $parameters['who_we_are_link'];
    }

    if (isset($parameters['who_we_are_link_text'])) {
        $whoLinkText = $parameters['who_we_are_link_text'];
    }

    if (isset($parameters['who_we_are_title'])) {
        $whoTitle = $parameters['who_we_are_title'];
    }

    if (isset($parameters['who_we_are_text'])) {
        $whoText = $parameters['who_we_are_text'];
    }

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

<div class="form-group col-12 col-lg-6 mt-1">
    <label>Header color style</label>
    <select name="parameters[hdr_color_type]" class="form-control">
        <option value="blue" @if(($hdrColorType) === 'blue') selected @endif>Blue</option>
        <option value="red" @if(($hdrColorType) === 'red') selected @endif>Red</option>
    </select>
</div>
<div class="form-group col-12 mt-2">
    <label>Header slider:</label>
    <nav>
        <div class="nav nav-tabs" id="nav-tab-header" role="tablist">
            @for ($i = 1; $i <= 4; $i++)
                <a class="nav-item nav-link @if($i === 1)active @endif" id="nav-action-tab-{{ $i }}"
                   data-toggle="tab"
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

                    <div class="col-12 mt-2">
                        <div class="form-check">
                            <input class="form-check-input" name="parameters[hdr_type_active_{{ $i }}]"
                                   type="checkbox"
                                   value="{{ $i }}" id="defaultCheck{{ $i }}"
                                   @empty(!$hdrTypeActive[$i]) checked @endempty>
                            <label class="form-check-label" for="defaultCheck{{ $i }}">
                                Active block
                            </label>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 mt-3">
                        <div class="form-group">
                            <label>Header link text:</label>
                            <input class="form-control" name="parameters[hdr_link_text_{{ $i }}]"
                                   placeholder="Header link text" value="{{ $hdrLinkText[$i]  }}"/>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 mt-lg-3">
                        <div class="form-group">
                            <label>Header learn more link:</label>
                            <input class="form-control" name="parameters[hdr_learn_more_link_{{ $i }}]"
                                   placeholder="Header learn more link" value="{{ $hdrLearnMoreLink[$i]  }}"/>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>Header title:</label>
                            <textarea class="form-control" name="parameters[hdr_title_{{ $i }}]"
                                      placeholder="Life changing support text">{{ $hdrTitle[$i] }}</textarea>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>Header text:</label>
                            <textarea class="form-control" name="parameters[hdr_text_{{ $i }}]"
                                      placeholder="Life changing support text">{{ $hdrText[$i] }}</textarea>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>Background image name:</label>
                            <input class="form-control" name="parameters[hdr_bg_image_{{ $i }}]"
                                   placeholder="Background image name" value="{{ $hdrBgImage[$i] }}"/>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>
<div class="row col-12">
    <div class="col-12 col-lg-6 mt-5">
        <div class="form-group">
            <label>Who we are video:</label>
            <input class="form-control" required name="parameters[who_we_are_video]" placeholder="Who we are video"
                   value="{{ $whoVideo }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6 mt-lg-5">
        <div class="form-group ">
            <label>Who we are link:</label>
            <input class="form-control" required name="parameters[who_we_are_link]" placeholder="Who we are link"
                   value="{{ $whoLink }}"/>
        </div>
    </div>

    <div class="form-group col-12 col-lg-6">
        <label>Who we are link text:</label>
        <input class="form-control" required name="parameters[who_we_are_link_text]" placeholder="Who we are link text"
               value="{{ $whoLinkText }}" maxlength="125"/>
    </div>

    <div class="form-group col-12 col-lg-6">
        <label>Who we are title:</label>
        <input class="form-control" required name="parameters[who_we_are_title]" placeholder="Who we are title"
               value="{{ $whoTitle }}"/>
    </div>

    <div class="form-group col-12 col-lg-6">
        <label>Who we are text:</label>
        <textarea class="form-control" required name="parameters[who_we_are_text]"
                  placeholder="Insert Who we are text">{{ $whoText }}</textarea>
    </div>
</div>
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

@include('modules.admin.lets_join')

<div class="col-12 mt-5">
    @include('modules.admin.join_the_cause_subscribe2', [
        'parameters' => $parameters
    ])
</div>

@include('modules.admin.current_projects', [
    'parameters' => $parameters
])



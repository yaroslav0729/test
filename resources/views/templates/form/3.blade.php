@php

    $hdrTypeActive = [];
    $hdrColorType = "";
    $hdrLinkText = [];
    $hdrLearnMoreLink = [];
    $hdrTitle = [];
    $hdrText = [];
    $hdrBgImage = [];

    $tagText = '';
    $tagClass = '';

    for ($i=1; $i<=4; $i++) {
        $hdrTypeActive[$i] = "";
        $hdrLinkText[$i] = "";
        $hdrLearnMoreLink[$i] = "";
        $hdrTitle[$i] = "";
        $hdrText[$i] = "";
        $hdrBgImage[$i] = "";
        $donateLink[$i] = "";
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
        if (isset($parameters['hdr_donate_link_' .$i])) {
            $donateLink[$i] = $parameters['hdr_donate_link_' . $i];
        }
    }

    if (isset($parameters['tag_text'])) {
        $tagText = $parameters['tag_text'];
    }

    if (isset($parameters['tag_class'])) {
        $tagClass= $parameters['tag_class'];
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

                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label>Donate now link:</label>
                            <input class="form-control" name="parameters[hdr_donate_link_{{ $i }}]"
                                   placeholder="Donate now link" value="{{ $donateLink[$i]  }}"/>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>

<div class="row">
<div class="col-12 col-lg-6 mt-lg-5">
    <div class="form-group ">
        <label>Tag text:</label>
        <input class="form-control" name="parameters[tag_text]" placeholder="Example: Ramathan"
               value="{{ $tagText }}"/>
    </div>
</div>
<div class="col-12 col-lg-6 mt-lg-5">
    <div class="form-group ">
        <label>Tag classes:</label>
        <input class="form-control" name="parameters[tag_class]" placeholder="Example: bg-info-light text-info"
               value="{{ $tagClass }}"/>
    </div>
</div>
</div>

@include('modules.admin.who_we_are')

@include('modules.admin.our_work')

@include('modules.admin.current_projects')

@include('modules.admin.lets_join')

@include('modules.admin.view_all_projects')


<div class="col-12 mt-5">
    @include('modules.admin.join_the_cause_subscribe2')
</div>





@php

    $needTitle = "";
    $needText = "";
    $needLinkText = "";
    $needLink = "";
    $needPhoto = "";
    $bgColor = "";
    $btnColor = "";


    if (isset($parameters['need_title'])) {
        $needTitle = $parameters['need_title'];
    }

    if (isset($parameters['need_text'])) {
        $needText = $parameters['need_text'];
    }

    if (isset($parameters['need_link_text'])) {
        $needLinkText = $parameters['need_link_text'];
    }

    if (isset($parameters['need_link'])) {
        $needLink = $parameters['need_link'];
    }

    if (isset($parameters['need_photo'])) {
        $needPhoto = $parameters['need_photo'];
    }

    if (isset($parameters['is_help_bg_color'])) {
        $bgColor = $parameters['is_help_bg_color'];
    }

    if (isset($parameters['is_help_btn_color'])) {
        $btnColor = $parameters['is_help_btn_color'];
    }

@endphp

<div class="row mt-lg-5">
    <div class="col-12">
        <h3 class="text-center">Islamic Help needs module:</h3>
    </div>
    <div class="col-12 col-lg-6 mt-lg-3">
        <div class="form-group">
            <label>Title:</label>
            <input class="form-control" name="parameters[need_title]"
                   placeholder="Title" value="{{ $needTitle }}"/>
        </div>
    </div>
    <div class="col-12 col-lg-6 mt-lg-3">
        <div class="form-group">
            <label>Text</label>
            <textarea class="form-control" name="parameters[need_text]">{!! $needText !!}</textarea>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Link text:</label>
            <input class="form-control" name="parameters[need_link_text]"
                   placeholder="Link text" value="{{ $needLinkText }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Link:</label>
            <input class="form-control" name="parameters[need_link]"
                   placeholder="Insert link" value="{{ $needLink }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Photo:</label>
            <input class="form-control" name="parameters[need_photo]"
                   placeholder="Insert image path" value="{{ $needPhoto }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Background color class name (blue - by default):</label>
            <input class="form-control" name="parameters[is_help_bg_color]"
                   placeholder="Insert class name (bg-white for example)" value="{{ $bgColor }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Button color class name (red - by default):</label>
            <input class="form-control" name="parameters[is_help_btn_color]"
                   placeholder="Insert class name (btn-danger for example)" value="{{ $btnColor }}"/>
        </div>
    </div>

</div>


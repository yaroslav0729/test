@php
    $title1 = "";
    $title2 = "";
    $text1 = "";
    $text2 = "";
    $img1 = "";
    $img2 = "";
    $video1 = "";
    $video1Preview = "";
    $video2 = "";
    $video2Preview = "";
    $link1 = "";
    $link2 = "";
    $linkText1 = "";
    $linkText2 = "";
    $text3 = "";
    $link3 = "";
    $btnTitle3 = "";

    if (isset($parameters['lets_title1'])) {
        $title1 = $parameters['lets_title1'];
    }

    if (isset($parameters['lets_title2'])) {
        $title2 = $parameters['lets_title2'];
    }

    if (isset($parameters['lets_text1'])) {
        $text1 = $parameters['lets_text1'];
    }

    if (isset($parameters['lets_text2'])) {
        $text2 = $parameters['lets_text2'];
    }

    if (isset($parameters['lets_img1'])) {
        $img1 = $parameters['lets_img1'];
    }

    if (isset($parameters['lets_img2'])) {
        $img2 = $parameters['lets_img2'];
    }

    if (isset($parameters['lets_video1'])) {
        $video1 = $parameters['lets_video1'];
    }

    if (isset($parameters['lets_video1_preview'])) {
        $video1Preview = $parameters['lets_video1_preview'];
    }

    if (isset($parameters['lets_video2'])) {
        $video2 = $parameters['lets_video2'];
    }

    if (isset($parameters['lets_video2_preview'])) {
        $video2Preview = $parameters['lets_video2_preview'];
    }

    if (isset($parameters['lets_link1'])) {
        $link1 = $parameters['lets_link1'];
    }

    if (isset($parameters['lets_link2'])) {
        $link2 = $parameters['lets_link2'];
    }

    if (isset($parameters['lets_link_text1'])) {
        $linkText1 = $parameters['lets_link_text1'];
    }

    if (isset($parameters['lets_link_text2'])) {
        $linkText2 = $parameters['lets_link_text2'];
    }

    if (isset($parameters['lets_link_text3'])) {
        $text3 = $parameters['lets_link_text3'];
    }

    if (isset($parameters['lets_link3'])) {
        $link3 = $parameters['lets_link3'];
    }

    if (isset($parameters['lets_btn_title3'])) {
        $btnTitle3 = $parameters['lets_btn_title3'];
    }

@endphp

<h3 class="text-center">Let's join module:</h3>

<ul class="nav nav-tabs" id="letsJoin" role="tablist">
    @for ($i = 1; $i <= 3; $i++)
        <li class="nav-item">
            <a class="nav-link @if($i===1) active @endif" id="tab-slide-{{ $i }}" data-toggle="tab" href="#lets_slide_{{ $i }}" role="tab" aria-controls="tab-slide-{{ $i }}" aria-selected="@if($i===0) true @else false @endif">Block {{ $i }}</a>
        </li>
    @endfor
</ul>

<div class="tab-content" id="myLetsJoinTabContent">
    <div class="tab-pane fade show active mt-lg-3" id="lets_slide_1" role="tabpanel" aria-labelledby="tab-slide-1">
        <div class="row">
            <div class="form-group col-12 col-lg-6">
                <label>Title 1:</label>
                <input class="form-control" name="parameters[lets_title1]" placeholder="Insert title" value="{{ $title1 }}" />
            </div>

            <div class="form-group col-12 col-lg-6">
                <label>Image 1:</label>
                <input class="form-control" name="parameters[lets_img1]" placeholder="Insert path" value="{{ $img1 }}" />
            </div>
        </div>
        <div class="row">
            <div class="form-group col-12 col-lg-6">
                <label>Video 1:</label>
                <input class="form-control" name="parameters[lets_video1]" placeholder="Insert path" value="{{ $video1 }}" />
            </div>

            <div class="form-group col-12 col-lg-6">
                <label>Video 1 preview:</label>
                <input class="form-control" name="parameters[lets_video1_preview]" placeholder="Insert path" value="{{ $video1Preview }}" />
            </div>

            <div class="form-group col-12 col-lg-6">
                <label>Text 1:</label>
                <input class="form-control" name="parameters[lets_text1]" placeholder="Insert text" value="{{ $text1 }}" />
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12 col-lg-6">
                <label>Link text 1:</label>
                <input class="form-control" name="parameters[lets_link_text1]" placeholder="Insert link text" value="{{ $linkText1 }}" />
            </div>

            <div class="form-group col-12 col-lg-6">
                <label>Link 1:</label>
                <input class="form-control" name="parameters[lets_link1]" placeholder="Insert link" value="{{ $link1 }}" />
            </div>
        </div>

    </div>

    <div class="tab-pane fade mt-lg-3" id="lets_slide_2" role="tabpanel" aria-labelledby="tab-slide-2">
        <div class="row">
            <div class="form-group col-12 col-lg-6">
                <label>Title 2:</label>
                <input class="form-control" name="parameters[lets_title2]" placeholder="Insert title" value="{{ $title2 }}" />
            </div>

            <div class="form-group col-12 col-lg-6">
                <label>Image 2:</label>
                <input class="form-control" name="parameters[lets_img2]" placeholder="Insert image" value="{{ $img2 }}" />
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12 col-lg-6">
                <label>Video 2:</label>
                <input class="form-control" name="parameters[lets_video2]" placeholder="Insert path" value="{{ $video2 }}" />
            </div>

            <div class="form-group col-12 col-lg-6">
                <label>Video 2 preview:</label>
                <input class="form-control" name="parameters[lets_video2_preview]" placeholder="Insert path" value="{{ $video2Preview }}" />
            </div>

            <div class="form-group col-12 col-lg-6">
                <label>Text 2:</label>
                <input class="form-control" name="parameters[lets_text2]" placeholder="Insert text" value="{{ $text2 }}" />
            </div>
        </div>

        <div class="row">
            <div class="form-group col-12 col-lg-6">
                <label>Link text 2:</label>
                <input class="form-control" name="parameters[lets_link_text2]" placeholder="Insert link text" value="{{ $linkText2 }}" />
            </div>

            <div class="form-group col-12 col-lg-6">
                <label>Link 2:</label>
                <input class="form-control" name="parameters[lets_link2]" placeholder="Insert link" value="{{ $link2 }}" />
            </div>
        </div>
    </div>

    <div class="tab-pane fade mt-lg-3" id="lets_slide_3" role="tabpanel" aria-labelledby="tab-slide-3">
        <div class="form-group">
            <label>Text 3:</label>
            <input class="form-control" name="parameters[lets_link_text3]" placeholder="Insert text" value="{{ $text3 }}" />
        </div>

        <div class="form-group">
            <label>Link 3:</label>
            <input class="form-control" name="parameters[lets_link3]" placeholder="Insert link" value="{{ $link3 }}" />
        </div>

        <div class="form-group">
            <label>Button title 3:</label>
            <input class="form-control" name="parameters[lets_btn_title3]" placeholder="Button title" value="{{ $btnTitle3 }}" />
        </div>
    </div>

</div>







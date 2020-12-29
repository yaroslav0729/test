@php
    $title1 = "";
    $title2 = "";
    $text1 = "";
    $text2 = "";
    $img1 = "";
    $img2 = "";
    $link1 = "";
    $link2 = "";
    $linkText1 = "";
    $linkText2 = "";
    $text3 = "";
    $link3 = "";

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
    
@endphp

<h3 class="text-center">Let's join module:</h3>

<div class="form-group">
    <label>Title1:</label>
    <input class="form-control" name="parameters[lets_title1]" placeholder="Insert title" value="{{ $title1 }}" />
</div>

<div class="form-group">
    <label>Image 1:</label>
    <input class="form-control" name="parameters[lets_img1]" placeholder="Insert image" value="{{ $img1 }}" />
</div>

<div class="form-group">
    <label>Text1:</label>
    <input class="form-control" name="parameters[lets_text1]" placeholder="Insert text" value="{{ $text1 }}" />
</div>

<div class="form-group">
    <label>Link text1:</label>
    <input class="form-control" name="parameters[lets_link_text1]" placeholder="Insert link text" value="{{ $linkText1 }}" />
</div>

<div class="form-group">
    <label>Link1:</label>
    <input class="form-control" name="parameters[lets_link1]" placeholder="Insert link" value="{{ $link1 }}" />
</div>

<div class="form-group">
    <label>Title2:</label>
    <input class="form-control" name="parameters[lets_title2]" placeholder="Insert title" value="{{ $title2 }}" />
</div>

<div class="form-group">
    <label>Image 2:</label>
    <input class="form-control" name="parameters[lets_img2]" placeholder="Insert image" value="{{ $img2 }}" />
</div>

<div class="form-group">
    <label>Text2:</label>
    <input class="form-control" name="parameters[lets_text2]" placeholder="Insert text" value="{{ $text2 }}" />
</div>

<div class="form-group">
    <label>Link text2:</label>
    <input class="form-control" name="parameters[lets_link_text2]" placeholder="Insert link text" value="{{ $linkText2 }}" />
</div>

<div class="form-group">
    <label>Link2:</label>
    <input class="form-control" name="parameters[lets_link2]" placeholder="Insert link" value="{{ $link2 }}" />
</div>

<div class="form-group">
    <label>Text3:</label>
    <input class="form-control" name="parameters[lets_link_text3]" placeholder="Insert text" value="{{ $text3 }}" />
</div>

<div class="form-group">
    <label>Link 3:</label>
    <input class="form-control" name="parameters[lets_link3]" placeholder="Insert link" value="{{ $link3 }}" />
</div>
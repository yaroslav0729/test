@php

    $mainTitle = "";
    $startLink = "";
    $colTitle1 = "";
    $colText1 = "";
    $colTitle2 = "";
    $colText2 = "";
    $colTitle3 = "";
    $colText3 = "";

    if (isset($parameters['main_title'])) {
        $mainTitle = $parameters['main_title'];    
    }

    if (isset($parameters['start_link'])) {
        $startLink = $parameters['start_link'];    
    }

    if (isset($parameters['col_title1'])) {
        $colTitle1 = $parameters['col_title1'];    
    }

    if (isset($parameters['col_text1'])) {
        $colText1 = $parameters['col_text1'];    
    }

    if (isset($parameters['col_title1'])) {
        $colTitle2 = $parameters['col_title1'];    
    }

    if (isset($parameters['col_text2'])) {
        $colText2 = $parameters['col_text2'];    
    }

    if (isset($parameters['col_title3'])) {
        $colTitle3 = $parameters['col_title3'];    
    }

    if (isset($parameters['col_text3'])) {
        $colText3 = $parameters['col_text3'];    
    }

@endphp

<div class="form-group">
    <label>Main title:</label>
    <input class="form-control"  name="parameters[main_title]" placeholder="Insert title" value="{{ $mainTitle }}" />
</div>

<div class="form-group">
    <label>Start link:</label>
    <input class="form-control"  name="parameters[start_link]" placeholder="Insert link url" value="{{ $startLink }}" />
</div>

<div class="form-group">
    <label>Colimn 1 title:</label>
    <input class="form-control"  name="parameters[col_title1]" placeholder="Insert title" value="{{ $colTitle1 }}" />
</div>

<div class="form-group">
    <label>Column 1 text:</label>
    <input class="form-control"  name="parameters[col_text1]" placeholder="Insert title" value="{{ $colText1 }}" />
</div>

<div class="form-group">
    <label>Colimn 2 title:</label>
    <input class="form-control"  name="parameters[col_title2]" placeholder="Insert text" value="{{ $colTitle2 }}" />
</div>

<div class="form-group">
    <label>Column 2 text:</label>
    <input class="form-control"  name="parameters[col_text2]" placeholder="Insert title" value="{{ $colText2 }}" />
</div>

<div class="form-group">
    <label>Colimn 3 title:</label>
    <input class="form-control"  name="parameters[col_title3]" placeholder="Insert title" value="{{ $colTitle3 }}" />
</div>

<div class="form-group">
    <label>Column 3 text:</label>
    <input class="form-control"  name="parameters[col_text3]" placeholder="Insert title" value="{{ $colText3 }}" />
</div>

@include('modules.admin.related_page_expanded')
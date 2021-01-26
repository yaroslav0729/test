@php

    $minRead = "";
    $headerText="";
    $writtenBy="";
    $headerVideo = "";
    $articleHtml = "";


    if (isset($parameters['min_read'])) {
        $minRead = $parameters['min_read'];
    }

    if (isset($parameters['hdr_text'])) {
        $headerText = $parameters['hdr_text'];
    }

    if (isset($parameters['written_by'])) {
        $writtenBy = $parameters['written_by'];
    }

    if (isset($parameters['hdr_video'])) {
        $headerVideo = $parameters['hdr_video'];
    }

    if (isset($parameters['article_html'])) {
        $articleHtml = $parameters['article_html'];
    }

@endphp

<div class="form-group">
    <label>Min read parameter:</label>
    <input class="form-control" name="parameters[min_read]" placeholder="X min read text" value="{{ $minRead }}" />
</div>
<div class="form-group">
    <label>Header text</label>
    <textarea class="form-control" name="parameters[hdr_text]" placeholder="Insert header text">{{ $headerText }}</textarea>
</div>
<div class="form-group">
    <label>Written by:</label>
    <input class="form-control" name="parameters[written_by]" placeholder="Written by" value="{{ $writtenBy }}" />
</div>
<div class="form-group">
    <label>Header video:</label>
    <input class="form-control" name="parameters[hdr_video]" placeholder="Insert youtube video link" value="{{ $headerVideo }}" />
</div>
<div class="form-group">
    <label>Article html</label>
    <textarea wysiwyg-editor class="form-control" id="article_html" name="parameters[article_html]">{{ $articleHtml }}</textarea>
</div>

<hr>

@include('modules.admin.mission_possible')

@include('modules.admin.related_page_expanded')

@include('modules.admin.join_the_cause_subscribe')

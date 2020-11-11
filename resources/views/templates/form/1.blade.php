@php

    $minRead = "";
    $headerText="";
    $writtenBy="";
    $headerVideo = "";
    $articleHtml = "";
    $previewPageTitle = "";
    $previewPageText1 = "";
    $previewPageText2 = "";
    $previewPageLink = "";
    $previewPageImage = "";

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

    if (isset($parameters['preview_page_title'])) {
        $previewPageTitle = $parameters['preview_page_title'];    
    }

    if (isset($parameters['preview_page_text1'])) {
        $previewPageText1 = $parameters['preview_page_text1'];    
    }

    if (isset($parameters['preview_page_text2'])) {
        $previewPageText2 = $parameters['preview_page_text2'];    
    }

    if (isset($parameters['preview_page_link'])) {
        $previewPageLink = $parameters['preview_page_link'];    
    }

    if (isset($parameters['preview_page_image'])) {
        $previewPageImage = $parameters['preview_page_image'];    
    }

@endphp

<div class="form-group">
    <label>Min read parameter:</label>
    <input class="form-control" required name="parameters[min_read]" placeholder="X min read text" value="{{ $minRead }}" />
</div>
<div class="form-group">
    <label>Header text</label>
    <textarea class="form-control" required name="parameters[hdr_text]" placeholder="Insert header text">{{ $headerText }}</textarea>
</div>
<div class="form-group">
    <label>Written by:</label>
    <input class="form-control" required name="parameters[written_by]" placeholder="Written by" value="{{ $writtenBy }}" />
</div>
<div class="form-group">
    <label>Header video:</label>
    <input class="form-control" required name="parameters[hdr_video]" placeholder="Insert youtube video link" value="{{ $headerVideo }}" />
</div>
<div class="form-group">
    <label>Article html</label>
    <textarea wysiwyg-editor class="form-control" id="article_html" name="parameters[article_html]">{{ $articleHtml }}</textarea>
</div>

<hr>

<div class="form-group">
    <label>Preview page title:</label>
    <input class="form-control" required name="parameters[preview_page_title]" placeholder="Insert preview page title" value="{{ $previewPageTitle }}" />
</div>
<div class="form-group">
    <label>Preview page text1:</label>
    <textarea class="form-control" required name="parameters[preview_page_text1]" placeholder="Insert preview page text">{{ $previewPageText1 }}</textarea>
</div>
<div class="form-group">
    <label>Preview page text2:</label>
    <textarea class="form-control" required name="parameters[preview_page_text2]" placeholder="Insert preview page text2">{{ $previewPageText2 }}</textarea>
</div>
<div class="form-group">
    <label>Preview page link:</label>
    <input class="form-control" required name="parameters[preview_page_link]" placeholder="Insert preview page link" value="{{ $previewPageLink }}" />
</div>
<div class="form-group">
    <label>Preview page image:</label>
    <input class="form-control" required name="parameters[preview_page_image]" placeholder="Path to preview image" value="{{ $previewPageImage }}" />
</div>

@include('modules.admin.related_pages', [
    'parameters' => $parameters
])
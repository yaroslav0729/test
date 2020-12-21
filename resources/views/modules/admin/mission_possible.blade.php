@php 

    $previewPageTitle = "";
    $previewPageText1 = "";
    $previewPageText2 = "";
    $previewPageLink = "";
    $previewPageImage = "";

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

<h3 class="text-center">Mission possible module:</h3>

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
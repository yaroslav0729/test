@php
    $relPageTitle = "";
    $relPageLinkTitle = "";
    $relPageLink = "";
    $bgClass = "";

    if (isset($parameters['rel_page_title'])) {
        $relPageTitle = $parameters['rel_page_title'];
    }

    if (isset($parameters['rel_page_link_title'])) {
        $relPageLinkTitle = $parameters['rel_page_link_title'];
    }

    if (isset($parameters['rel_page_link'])) {
        $relPageLink = $parameters['rel_page_link'];
    }

    if (isset($parameters['bg_class'])) {
        $bgClass = $parameters['bg_class'];
    }
@endphp

<h3 class="text-center">Related pages expanded module:</h3>

<div class="form-group">
    <label>Relation page title (DISCOVER MORE - by default):</label>
    <input class="form-control" name="parameters[rel_page_title]" placeholder="Relation page title" value="{{ $relPageTitle }}" />
</div>

<div class="form-group">
    <label>Relation page link title (VISIT NEWSROOM - by default):</label>
    <input class="form-control" name="parameters[rel_page_link_title]" placeholder="Relation page link title" value="{{ $relPageLinkTitle }}" />
</div>

<div class="form-group">
    <label>Relation page link (/blog-page - by default):</label>
    <input class="form-control" name="parameters[rel_page_link]" placeholder="Relation page link" value="{{ $relPageLink }}" />
</div>

<div class="form-group">
    <label>Background class:</label>
    <input class="form-control" name="parameters[bg_class]" placeholder="Example - bg-light" value="{{ $bgClass }}" />
</div>

@include('modules.admin.related_pages', [
    'parameters' => $parameters
])





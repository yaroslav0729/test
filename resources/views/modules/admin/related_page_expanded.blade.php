@php
    $relPageTitle = "";
    $relPageLinkTitle = "";
    $relPageLink = "";

    if (isset($parameters['rel_page_title'])) {
        $relPageTitle = $parameters['rel_page_title'];
    }

    if (isset($parameters['rel_page_link_title'])) {
        $relPageLinkTitle = $parameters['rel_page_link_title'];
    }

    if (isset($parameters['rel_page_link'])) {
        $relPageLink = $parameters['rel_page_link'];
    }
@endphp

<div class="row">
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Relation page title:</label>
            <input class="form-control" name="parameters[rel_page_title]" placeholder="Relation page title" value="{{ $relPageTitle }}" />
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Relation page link title</label>
            <input class="form-control" name="parameters[rel_page_link_title]" placeholder="Relation page link title" value="{{ $relPageLinkTitle }}" />
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Relation page link:</label>
            <input class="form-control" name="parameters[rel_page_link]" placeholder="Relation page link" value="{{ $relPageLink }}" />
        </div>
    </div>
    <div class="col-12 col-lg-6">
        @include('modules.admin.related_pages', [
            'parameters' => $parameters
        ])
    </div>
</div>



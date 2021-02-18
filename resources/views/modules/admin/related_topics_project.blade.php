@php

    $page1 = '';
    $page2 = '';
    $page3 = '';
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

    if (isset($parameters['proj_rel_page_1'])) {
        $page1 = $parameters['proj_rel_page_1'];
    }

    if (isset($parameters['proj_rel_page_2'])) {
        $page2 = $parameters['proj_rel_page_2'];
    }

    if (isset($parameters['proj_rel_page_3'])) {
        $page3 = $parameters['proj_rel_page_3'];
    }

    $bgClass = "";

    if (isset($parameters['bg_class'])) {
        $bgClass = $parameters['bg_class'];
    }

@endphp

<div class="row mt-lg-5">
    <div class="col-12">
        <h3 class="text-center">Related topics projects module:</h3>
    </div>

    <div class="col-12 col-lg-6 mt-lg-3">
        <div class="form-group">
            <label>Relation topics title (RELATED TOPICS - by default):</label>
            <input class="form-control" name="parameters[rel_page_title]" placeholder="Relation page title"
                   value="{{ $relPageTitle }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6  mt-lg-3">
        <div class="form-group">
            <label>Background class (bg-white - by default):</label>
            <input class="form-control" name="parameters[bg_class]" placeholder="Example - bg-light"
                   value="{{ $bgClass }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Relation page link title (VISIT NEWSROOM - by default):</label>
            <input class="form-control" name="parameters[rel_page_link_title]" placeholder="Relation page link title" value="{{ $relPageLinkTitle }}" />
        </div>
    </div>

    <div class="col-12 col-lg-6 ">
        <div class="form-group">
            <label>Relation page link (/newsroom - by default):</label>
            <input class="form-control" name="parameters[rel_page_link]" placeholder="Relation page link" value="{{ $relPageLink }}" />
        </div>
    </div>

    <div class="form-group col-12 col-lg-4">
        <label>Topic id 1:</label>
        <input class="form-control" name="parameters[proj_rel_page_1]" placeholder="Insert topic id"
               value="{{ $page1 }}"/>
    </div>

    <div class="form-group col-12 col-lg-4">
        <label>Topic id 2:</label>
        <input class="form-control" name="parameters[proj_rel_page_2]" placeholder="Insert topic id"
               value="{{ $page2 }}"/>
    </div>

    <div class="form-group col-12 col-lg-4">
        <label>Topic id 3:</label>
        <input class="form-control" name="parameters[proj_rel_page_3]" placeholder="Insert topic id"
               value="{{ $page3 }}"/>
    </div>
</div>



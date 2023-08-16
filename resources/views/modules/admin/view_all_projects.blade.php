@php

    $img = "";
    $title = "";
    $description = "";
    $linkTitle = "";
    $link = "";
    $linkAllTitle = "";
    $linkAll = "";

    if (isset($parameters['view_all_projects_img'])) {
        $img = $parameters['view_all_projects_img'];
    }

    if (isset($parameters['view_all_projects_title'])) {
        $title = $parameters['view_all_projects_title'];
    }

    if (isset($parameters['view_all_projects_description'])) {
        $description = $parameters['view_all_projects_description'];
    }

    if (isset($parameters['view_all_projects_link_title'])) {
        $linkTitle = $parameters['view_all_projects_link_title'];
    }

    if (isset($parameters['view_all_projects_link'])) {
        $link = $parameters['view_all_projects_link'];
    }

    if (isset($parameters['view_all_projects_link_all_title'])) {
        $linkAllTitle = $parameters['view_all_projects_link_all_title'];
    }

    if (isset($parameters['view_all_projects_link_all'])) {
        $linkAll = $parameters['view_all_projects_link_all'];
    }

@endphp

<h3 class="text-center">View all projects module:</h3>

<div class="row">
    <div class="form-group col-12 col-lg-6">
        <label>Image:</label>
        <input class="form-control" name="parameters[view_all_projects_img]" placeholder="Insert path"
               value="{{ $img }}"/>
    </div>

    <div class="form-group col-12 col-lg-6">
        <label>Title:</label>
        <input class="form-control" name="parameters[view_all_projects_title]" placeholder="Insert value"
               value="{{ $title }}"/>
    </div>
</div>

<div class="form-group">
    <label>Description:</label>
    <input class="form-control" name="parameters[view_all_projects_description]" placeholder="Insert value"
           value="{{ $description }}"/>
</div>

<div class="row">
    <div class="form-group col-12 col-lg-6">
        <label>Learn more title:</label>
        <input class="form-control" name="parameters[view_all_projects_link_title]" placeholder="Learn more title"
               value="{{ $linkTitle }}"/>
    </div>

    <div class="form-group col-12 col-lg-6">
        <label>Learn more link:</label>
        <input class="form-control" name="parameters[view_all_projects_link]" placeholder="Learn more link"
               value="{{ $link }}"/>
    </div>
</div>

<div class="row">
    <div class="form-group col-12 col-lg-6">
        <label>View all projects title:</label>
        <input class="form-control" name="parameters[view_all_projects_link_all_title]" placeholder="Insert value"
               value="{{ $linkAllTitle }}"/>
    </div>

    <div class="form-group col-12 col-lg-6">
        <label>View all projects link:</label>
        <input class="form-control" name="parameters[view_all_projects_link_all]" placeholder="Insert value"
               value="{{ $linkAll }}"/>
    </div>
</div>


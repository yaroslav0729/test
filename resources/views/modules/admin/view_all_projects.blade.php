@php

$img = "";
$title = "";
$description = "";
$link = "";
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

if (isset($parameters['view_all_projects_link'])) {
    $link = $parameters['view_all_projects_link'];    
}

if (isset($parameters['view_all_projects_link_all'])) {
    $linkAll = $parameters['view_all_projects_link_all'];    
}
    
@endphp

<h3 class="text-center">View all projects module:</h3>

<div class="form-group">
    <label>Image:</label>
    <input class="form-control" name="parameters[view_all_projects_img]" placeholder="Insert path"
            value="{{ $img }}"/>
</div>

<div class="form-group">
    <label>Title:</label>
    <input class="form-control" name="parameters[view_all_projects_title]" placeholder="Insert value"
            value="{{ $title }}"/>
</div>

<div class="form-group">
    <label>Description:</label>
    <input class="form-control" name="parameters[view_all_projects_description]" placeholder="Insert value"
            value="{{ $description }}"/>
</div>

<div class="form-group">
    <label>Link learn more:</label>
    <input class="form-control" name="parameters[view_all_projects_link]" placeholder="Insert value"
            value="{{ $link }}"/>
</div>

<div class="form-group">
    <label>Link view all projects:</label>
    <input class="form-control" name="parameters[view_all_projects_link_all]" placeholder="Insert value"
            value="{{ $linkAll }}"/>
</div>
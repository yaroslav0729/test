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
    
    $title = str_replace('[', '<b>', $title);
    $title = str_replace(']', '</b>', $title);
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

<section class="widget-about-project">
    <div class="row gutter-0">
        <div class="col-12 descr">
            <div class="text-right mb-4">
                <a href="{{ $linkAll }}"><i class="moon-icons-plus"></i></a>
            </div>
            <div>
                <p class="font-size-25 text-uppercase" style="font-weight: 100">{!! $title !!}</p>
                <p class="font-size-16" style="font-weight: 700">{{ $description }}</p>
                <a href="{{ $link }}" class="text-underline ">LEARN MORE</a>
            </div>
        </div>
        <div class="col-12 img" style="background-image: url({{ $img }})"></div>

    </div>
</section>
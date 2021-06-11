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

    $title = str_replace('[', '<b>', $title);
    $title = str_replace(']', '</b>', $title);
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

<section class="widget-about-project">
    <div class="row gutter-0">
        <div class="col-6"><a href="{{ $linkAll }}" class="view-more text-underline text-uppercase">{{ $linkAllTitle }}<i
                    class="moon-icons-arrow-up"></i></a></div>
    </div>
    <div class="row gutter-0">
        <div class="col-12 col-lg-6 img" style="background-image: url({{ $img }})"></div>
        <div class="col-12 col-lg-6 descr d-flex align-items-center">
            <div>
                <p class="font-size-30 text-uppercase descr-title" style="font-weight: 100"> {!! $title !!}
                </p>
                <p class="font-size-16" style="font-weight: 700">{{ $description }}</p>
                <a href="{{ $link }}" class="text-underline text-uppercase">{{ $linkTitle }}</a>
            </div>
        </div>
    </div>
</section>

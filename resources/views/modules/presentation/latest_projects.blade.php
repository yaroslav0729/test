@php
    $latestProjects = \App\Models\Project::getLatest();
@endphp

<section class="current-projects-list">
    <div class="wrap">
        <div class="row">
            @foreach($latestProjects as $page)
                @php
                    $project = $page->actual_page_instance;
                @endphp

                <div class="col-4 slide">
                    <a href="{{ $project->slug }}" class="item">
                        <span class="img slide-img" style="background-image: url({{ $project->preview_img }})"></span>
                        <span class="descr">
                            <span class="name font-weight-bold  font-size-16 slide-title">{{ $project->title }}</span>
                            <span class="text font-size-16 slide-text">{{ $project->preview_text }}</span>
                        </span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
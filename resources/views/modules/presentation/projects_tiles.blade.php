<div class="wrap">
    <div class="row">

        @php
            $projects = \App\Models\Page::getAllProjects();
        @endphp

        @foreach ($projects as $projKey => $project)

            @php
                $projInstance = $project->actual_page_instance;
            @endphp

            <div class="col-12 col-md-6 col-lg-6 col-xl-4">
                <div class="item">
                    <div class="img" style="background-image: url({{ $projInstance->preview_img }})">
                        <div class="top-bar">
                            <div class="add" data-popup="{{ $projKey }}"><i class="far fa-plus"></i></div>
                            
                            @include('modules.presentation.parts.projects_tiles_popup', ['popupKey' => $projKey])
                        </div>
                    </div>
                    <div class="descr">
                        <div class="name"><b>SPONSOR AN ORPHAN</b></div>
                        <div class="text-right"><a target="_blank" href="{{ url('/' . $projInstance->slug) }}" class="text-uppercase text-underline text-dark">LEARN MORE</a></div>
                    </div>
                </div>
            </div>

        @endforeach

        

        {{-- <div class="col-12 col-md-6 col-lg-6 col-xl-4">
            <div class="item selected">
                <div class="img" style="background-image: url(img/content/join-cause-2.jpg)">
                    <div class="top-bar">
                        <div class="add"><i class="far fa-plus"></i></div>
                        <div class="price">£250  <span class="ml-2">+Sadiqah</span></div>
                        <i class="fal fa-check"></i>
                    </div>
                </div>
                <div class="descr">
                    <div class="name"><b>Sponsor an orphan</b></div>
                    <div class="text-right"><a href="#" class="text-uppercase text-underline text-dark">LEARN MORE</a></div>
                </div>
            </div>
        </div> --}}

    </div>

</div>
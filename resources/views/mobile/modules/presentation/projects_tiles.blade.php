<div class="donate-projects-list w-100" swiper-wrapper="project-tiles">
    <div class="swiper-container">
        <div class="swiper-wrapper">

            @php
                $tileCou = 0;    
            @endphp

            @foreach ($projects as $projKey => $project)

                @php
                    $projInstance = $project->actual_page_instance;
                @endphp

                @if($tileCou === 0)

                <div class="swiper-slide">
                    <div class="">
                        <div class="row">

                @endif

                <div class="col-12 col-md-6 col-lg-6 col-xl-4">
                    <div class="item">
                        <div class="img" style="background-image: url({{ $projInstance->preview_img }})"></div>
                        <div class="descr">
                            <div class="name text-ellipsis"><b>{{ $projInstance->name }}</b></div>
                            <div><a href="{{ url('/' . $projInstance->slug) }}" class="font-size-14 text-uppercase text-info"><b>LEARN MORE</b></a></div>
                            <div class="add" data-popup="{{ $projKey }}">
                                <i class="far fa-plus"></i>
                            </div>

                            @include('modules.presentation.parts.projects_tiles_popup', ['popupKey' => $projKey])
                        </div>
                    </div>
                </div>

                @php
                            
                    if ($tileCou < 2) {
                        $tileCou++;
                    } else {
                        $tileCou = 0;
                    }

                @endphp

                @if(($tileCou === 0) || ($projKey + 1 === count($projects)))
                        </div>
                    </div>
                </div>
                @endif

            @endforeach

        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
</div>
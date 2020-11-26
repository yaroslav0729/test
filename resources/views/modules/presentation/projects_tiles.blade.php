<div class="current-projects-list w-100" swiper-wrapper="project-tiles">
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
                                <div class="img" style="background-image: url({{ $projInstance->preview_img }})">
                                    <div class="top-bar">
                                        <div class="add" data-popup="{{ $projKey }}"><i class="far fa-plus"></i></div>
                                        
                                        @include('modules.presentation.parts.projects_tiles_popup', ['popupKey' => $projKey])
                                    </div>
                                </div>
                                <div class="descr">
                                    <div class="name"><b>{{ $projInstance->name }}</b></div>
                                    <div class="text-right"><a target="_blank" href="{{ url('/' . $projInstance->slug) }}" class="text-uppercase text-underline text-dark">LEARN MORE</a></div>
                                </div>
                            </div>
                        </div>

                        @php
                            
                            if ($tileCou < 5) {
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

    
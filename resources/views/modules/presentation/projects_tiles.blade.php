<div class="current-projects-list w-100" swiper-wrapper="{{ isset($wrapperAttr) ? $wrapperAttr : 'project-tiles' }}">

    <div class="project_popup_options alert alert-warning d-none">
        {{-- Options will be here --}}
    </div>

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
                                <div class="row gutter-22">

                        @endif

                        <div class="col-12 col-md-6 col-lg-6 col-xl-4">
                            <div class="item">
                                <!-- <div class="img add" style="background-image: url({{ $projInstance->preview_img }})" data-id="{{ $projInstance->id}}"> -->
                                <div class="img" style="background-image: url({{ $projInstance->preview_img }})">
                                    <div class="add add-container" data-id="{{$projInstance->id}}"></div>
                                    <div class="top-bar">
                                        <div class="add" data-id="{{ $projInstance->id}} "><i class="moon-icons-plus"></i></div>
                                        <div class="add-width bg-danger d-none" data-id="{{ $projInstance->id}}">
                                            <div class="col-12 d-flex justify-content-between">
                                                <div class="text-white align-self-center text-value font-weight-bold font-size-20"></div>
                                                <div class="align-right">
                                                    <i class="d-block text-white moon-icons-check font-size-25 align-right"></i>
                                                </div>
                                            </div>
                                        </div>

                                        @include('modules.presentation.parts.projects_tiles_popup', ['popupKey' => $projInstance->id])
                                    </div>
                                </div>
                                <div class="descr">
                                    <div class="name"><b>{{ $projInstance->name }}</b></div>
                                    <div class="text-right"><a target="_blank" href="{{ url('/' . $projInstance->slug) }}" class="text-uppercase text-underline text-dark letter-spacing-1">LEARN MORE</a></div>
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

                    @endforeach        </div>
        <div class="swiper-pagination" test-attribute></div>
    </div>
</div>


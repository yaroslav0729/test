@php

    $donateToProjTitle = "";

    if (isset($parameters['donate_to_title'])) {
        $donateToProjTitle = $parameters['donate_to_title'];
    }

    $donateToProjText = "";

    if (isset($parameters['donate_to_text'])) {
        $donateToProjText = $parameters['donate_to_text'];
    }

@endphp

@if($projects)
    <section class="donate-projects-list d-none">
        <div class="title text-center">
            <p><b>{{ $donateToProjTitle }}</b></p>
        </div>
        <div class="row filter_projects_appeal" filter-projects>
            <div class="donate-projects-list w-100">
                <div class="project_popup_options alert alert-warning d-none">
                    {{-- Options will be here --}}
                </div>
                @include('modules.presentation.parts.project_tiles_modal_wrapper')

                @foreach ($projects as $projKey => $project)
                    @php $projInstance = $project->actual_page_instance; @endphp
                    <div class="">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6 col-xl-4">
                                <div class="item">
                                    <div class="img"
                                         style="background-image: url({{ $projInstance->preview_img }})"></div>
                                    <div class="descr">
                                        <div class="name text-ellipsis"><b>{{ $projInstance->name }}</b></div>
                                        <div><a href="{{ url('/' . $projInstance->slug) }}"
                                                class="font-size-14 text-uppercase text-info"><b>LEARN MORE</b></a>
                                        </div>

                                        <div zakat-donate-btn class="add" data-id="{{ $projInstance->id}}">
                                            <i class="moon-icons-plus"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

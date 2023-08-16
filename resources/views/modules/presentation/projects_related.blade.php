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
        <div class="title">
            <div class="wrap">
                <div class="row">
                    <div class="col-12">
                        @empty($donateToProjTitle)
                            <p class="font-size-30"><b>Donate to a project too?</b></p>
                        @else
                            <p class="font-size-30"><b>{{ $donateToProjTitle }}</b></p>
                        @endempty

                        @empty($donateToProjText)
                            <p class="font-size-16">You could also join the journey to support our causes that empower
                                those in need each month/single donation 100ch.</p>
                        @else
                            <p class="font-size-16">{{ $donateToProjText }}</p>
                        @endempty
                    </div>
                </div>
            </div>
        </div>

        <div class="filter_projects_single">
            <div class="current-projects-list w-100">
                <div class="project_popup_options alert alert-warning d-none">
                </div>
                <div class="row">
                    @foreach ($projects as $projKey => $project)
                        @php $projInstance = $project->actual_page_instance; @endphp
                        <div class="col-12 col-md-6 col-lg-6 col-xl-4">
                            <div class="item">
                                <div class="img" style="background-image: url({{ $projInstance->preview_img }})">
                                    <div class="top-bar">
                                        <div zakat-donate-btn class="add-wide pl-4 d-flex justify-content-around" data-id="{{ $projInstance->id}}">
                                            <div class="align-baseline">
                                                Donate my Zakat
                                            </div>
                                            <div class="mr-2">
                                                <i class="moon-icons-plus align-baseline"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="descr">
                                    <div class="name"><b>{{ $projInstance->name }}</b></div>
                                    <div class="text-right"><a target="_blank" href="{{ url('/' . $projInstance->slug) }}"
                                                               class="text-uppercase text-underline text-dark">LEARN MORE</a></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </section>
@endif

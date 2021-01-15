<div class="header-menu">
    <div class="wrap">
        <div class="row align-items-center">
            <div class="col-9">
                <a href="{{ route('index') }}" class="logo">
                    <span><img src="/img/logo.png" width="35" height="35" style="margin: 8px 0 0 8px" /></span></a>
                <ul class="d-inline-flex justify-content-between">
                    @isset ($headerMenuItem[0])
                        @foreach($headerMenuItem[0] as $itemMenu)
                            <li
                                opened-menu-item
                                data-id="{{ $itemMenu->id }}"
                            >
                                <a href="#">{{ $itemMenu->text }}</a>
                            </li>
                        @endforeach
                    @endisset
                </ul>
            </div>
            <div class="col-3 text-right">
                <a href="#" class="search-btn"><i class="ico-search"></i></a>
            </div>
        </div>

        @isset ($headerMenuItem[1])
            @foreach ($headerMenuItem[1] as $groupId => $itemMenu)
                <div class="block-dropdown-menu" data-id="{{ $groupId }}" style="display: block">
                    <div class="title">{{ $itemMenu['parent_text'] }}</div>
                    @if ($itemMenu['max_depth'] < 2)
                        <div>
                            @foreach ($itemMenu['items'] as $subItemMenu)
                                @if($loop->index % 3 === 0)
                                    @if($loop->index !== 0) </ul> @endif
                                    <ul class="menu">
                                @endif
                                <li><a href="{{ $subItemMenu->link }}">{{ $subItemMenu->text }}</a></li>
                                @if ($loop->last)
                                    </ul>
                                @endif
                            @endforeach
                        </div>
                        <div class="black-line">
                           <div class="head-menu-video">
                               <div class="img-video play-tr videoWrapper" style="">
                                   <iframe
                                       @if(Setting::get(Setting::VIDEO_LINK_ON_MAIN_MENU))
                                       src="https://www.youtube.com/embed/{{ Setting::get(Setting::VIDEO_LINK_ON_MAIN_MENU) }}"
                                       @endif
                                           frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                   <div class="overlay trigger"
                                        @if(Setting::get(Setting::VIDEO_LINK_ON_MAIN_MENU))
                                            src="https://www.youtube.com/embed/{{ Setting::get(Setting::VIDEO_LINK_ON_MAIN_MENU) }}"
                                        @else
                                            src=""
                                        @endif
                                        data-target="#videoModal" data-toggle="modal"></div>
                               </div>
                            </div>
                        </div>
                    @else
                        <div class="projects-group">
                            <div class="black-line"></div>

                            <div class="row">
                                <div class="col-4"></div>
                                <div class="col-8 text-right">
                                    <p class="mb=0">Empowering people around the world. Join our movement and find your cause for change.</p>
                                </div>
                            </div>

                            <div class="projects-group-swiper" swiper-wrapper-menu="menu-slider">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        @foreach ($itemMenu['items'] as $subItemMenu)
                                            @if($loop->index % 3 === 0)
                                                @if($loop->index !== 0) </div> @endif
                                                <div class="swiper-slide">
                                            @endif
                                            <a
                                                @if($subItemMenu->is_group)
                                                    href="#"
                                                    menu-group-show
                                                    data-menu-group-id="{{ $subItemMenu->id }}"
                                                @else
                                                    href="{{ $subItemMenu->link }}"
                                                @endif
                                                class="item"
                                            >
                                                {{ $subItemMenu->text }}
                                                @if($subItemMenu->is_group)
                                                    <i class="far fa-plus"></i>
                                                @endif
                                            </a>
                                            @if ($loop->last)
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                </div>
                            </div>
                        </div>
                        <div class="black-line"></div>
                    @endif
                </div>
            @endforeach
        @endisset

        @isset ($headerMenuItem[2])
            @foreach ($headerMenuItem[2] as $groupId => $itemMenu)
                <div style="display: none" menu-group data-menu-group-id="{{ $groupId }}">

                    <div class="title">{{ $itemMenu['parent_text'] }}</div>

                    <div>
                        <ul class="menu">
                            <li><a href="#">VIEW ALL CATEGORIES</a></li>
                        </ul>
                    </div>

                    <div class="black-line no-line">
                        <div class="head-menu-video">
                            <div class="img-video play-tr videoWrapper" style="">
                                <iframe
                                    @if(Setting::get(Setting::VIDEO_LINK_ON_MAIN_MENU))
                                        src="https://www.youtube.com/embed/{{ Setting::get(Setting::VIDEO_LINK_ON_MAIN_MENU) }}"
                                    @endif
                                        frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                <div class="overlay trigger"
                                     @if(Setting::get(Setting::VIDEO_LINK_ON_MAIN_MENU))
                                        src="https://www.youtube.com/embed/{{ Setting::get(Setting::VIDEO_LINK_ON_MAIN_MENU) }}"
                                     @else
                                         src=""
                                     @endif
                                     data-target="#videoModal" data-toggle="modal"></div>
                            </div>
                        </div>
                    </div>

                    <div class="categories">
                        <div class="name">
                            {{ $itemMenu['parent_text'] }}
                            <a href="#" menu-group-back><i class="far fa-long-arrow-left"></i></a>
                        </div>
                        <div class="categories-swiper">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    @foreach ($itemMenu['items'] as $subItemMenu)

                                        @if ($loop->index % 3 === 0)
                                            @if ($loop->index !== 0) </ul></div> @endif
                                            <div class="swiper-slide"><ul>
                                        @endif

                                        <li><a href="{{ $subItemMenu->link }}">{{ $subItemMenu->text }}</a></li>

                                        @if ($loop->last)
                                            </ul></div>
                                        @endif

                                    @endforeach
                                </div>
                                <div class="swiper-button-prev swiper-button-prev-{{ $groupId }}"><i class="far fa-arrow-left"></i></div>
                                <div class="swiper-button-next swiper-button-next-{{ $groupId }}"><i class="far fa-arrow-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="black-line"></div>
                </div>
            @endforeach
        @endisset

        <div>
            <div class="row align-items-center down-menu">
                <div class="col-8">
                    <ul class="d-flex justify-content-between">
                        @foreach($additionalHeaderMenuItem as $itemMenu)
                            <li><a href="{{ $itemMenu->link }}">{{ $itemMenu->text }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-4 text-right">
                    <a href="#" class="text-info mr-4" data-toggle="modal" data-target="#loginModal">Login</a>
                    <a href="#" class=" mr-4" data-toggle="modal" data-target="#createModal">+ Create account</a>
                    <a href="#" class="close-menu"><i class="far fa-times"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="embed-responsive embed-responsive-16by9">
                <iframe
                    @if(Setting::get(Setting::VIDEO_LINK_ON_MAIN_MENU))
                        src="https://www.youtube.com/embed/{{ Setting::get(Setting::VIDEO_LINK_ON_MAIN_MENU) }}"
                    @endif
                        frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>

@php
    $bgClass = "";
    $relPageTitle = "";
    $relPageLinkTitle = "";
    $relPageLink = "";

    if (isset($parameters['bg_class'])) {
        $bgClass = $parameters['bg_class'];
    }
    if (isset($parameters['rel_page_title'])) {
        $relPageTitle = $parameters['rel_page_title'];
    }

    if (isset($parameters['rel_page_link_title'])) {
        $relPageLinkTitle = $parameters['rel_page_link_title'];
    }

    if (isset($parameters['rel_page_link'])) {
        $relPageLink = $parameters['rel_page_link'];
    }

    $pageIds = [];

    if (isset($parameters['proj_rel_page_1'])) {
        $pageIds[] = $parameters['proj_rel_page_1'];
    }
    if (isset($parameters['proj_rel_page_2'])) {
        $pageIds[] = $parameters['proj_rel_page_2'];
    }
    if (isset($parameters['proj_rel_page_3'])) {
        $pageIds[] = $parameters['proj_rel_page_3'];
    }

    $pages = \App\Models\Project::getRelPages($pageIds);
    $lastBlogPages = \App\Models\Page::lastBlogs(3);

@endphp

<section class="discover-more @empty($bgClass) bg-white @else {{ $bgClass }} @endempty">
<div class="wrap">
    <div class="title">
        <div class="row">
            <div class="col-7">
                <b class="font-size-30 mr-4 text-uppercase">
                    @if ($relPageTitle === "")
                        RELATED TOPICS
                    @else
                        {{ $relPageTitle }}
                    @endif
                </b>
            </div>
            <div class="col-5 text-right pr-0">
                <a href="
                @if ($relPageLink === "")
                    /newsroom
                @else
                {{ $relPageLink }}
                @endif
                    " class="text-uppercase text-underline ">
                    <b>
                        @if ($relPageLinkTitle === "")
                            VISIT NEWSROOM
                        @else
                            {{ $relPageLinkTitle }}
                        @endif

                    </b> <i class="moon-icons-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <div class="current-projects-list">
        <div class="wrap">
            <div class="row gutter-5">
                @if(!$pages->isEmpty())
                    @foreach ($pages as $page)
                    <div class="col-4">
                        <a href="{{ $page->slug }}" class="item">
                            @isset($page->preview_img)
                                <span class="img" style="background-repeat:no-repeat; background-image: url({{ url($page->preview_img) }})"></span>
                            @else
                                <span class="img" style="background: #eee"></span>
                            @endisset

                            <span class="descr">
                            <span class="text font-size-16 text-uppercase">{{ \App\Helpers\StrHelper::lengthLimit($page->name, 20) }}</span>
                            <span class="name font-size-16 "><b>{{ \App\Helpers\StrHelper::lengthLimit($page->preview_text, 60) }}</b></span>
                            </span>
                        </a>
                    </div>
                    @endforeach
                @else
                    @foreach ($lastBlogPages as $blog)
                        <div class="col-4">
                            <a href="{{Request::root()}}/{{ $blog->getActualPageInstanceAttribute()->slug }}" class="item">
                                @isset($blog->getActualPageInstanceAttribute()->preview_img)
                                    <span class="img" style="background-repeat:no-repeat; background-image: url({{ $blog->getActualPageInstanceAttribute()->preview_img }})"></span>
                                @else
                                    <span class="img" style="background: #eee"></span>
                                @endisset

                                <span class="descr">
                            <span class="text font-size-16 text-uppercase font-weight-normal">{{ \App\Helpers\StrHelper::lengthLimit($blog->getActualPageInstanceAttribute()->name, 20) }}</span>
                            <span class="name font-size-16 "><b>{{ \App\Helpers\StrHelper::lengthLimit($blog->getActualPageInstanceAttribute()->parameters['hdr_text'], 60) }}</b></span>
                            </span>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
</section>

<div class="body">
    <div class="blog-video">
        <div class="img-video play-tr videoWrapper" style="background: #999">
            @if(count($parameters)>0)
                <iframe width="1280" height="720" src="https://www.youtube.com/embed/{{ $parameters[0] }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            @endif
        </div>
        @if(count($parameters)>1)
            <a href="javascript:void(0)" class="view-more"><i class="far fa-arrow-right"></i></a>
        @endif
        <div class="d-none blog-video-parameters alert alert-warning" data-current="0">
            <ul>
                @foreach ($parameters as $key => $link)
                    <li>{{ $link }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

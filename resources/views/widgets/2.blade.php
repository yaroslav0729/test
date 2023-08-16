<div class="body">
    <div class="blog-video">
        <div class="img-video play-tr videoWrapper" style="background: #999">
            @if (count($parameters) > 0)
                @php
                    $video = '';
                    $videoPreview = '';
                    $videoParameters = explode(',', $parameters[0]);
                    if (isset($videoParameters[0])) {
                        $video = $videoParameters[0];
                    }
                    if (isset($videoParameters[1])) {
                        $videoPreview = $videoParameters[1];
                    }
                @endphp
                <div class="video-poster">
                    <button class="video-poster__play video-poster__play--big"
                        data-url="https://www.youtube.com/embed/{{ $video }}"><i
                            class="ico-play"></i></button>
                    <img class="video-poster__img" src="@if (!$videoPreview) https://img.youtube.com/vi/{{ $video }}/maxresdefault.jpg @else {{ $videoPreview }} @endif">
                </div>
                <iframe width="1280" height="720" src="https://www.youtube.com/embed/{{ $video }}"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            @endif
        </div>
        @if (count($parameters) > 1)
            <a href="javascript:void(0)" class="view-more"><i class="moon-icons-arrow-right"></i></a>
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

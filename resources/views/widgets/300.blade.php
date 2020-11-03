<section class="blog-article-head">
    <div class="wrap">
        <div class="mb-4">
            <a href="{{ route('index') }}" class="btn-back"><i class="far fa-arrow-left"></i> BACK</a>
        </div>

        <div class="row">
            <div class="col-5 article-text">
                <h1>{{ $post->name }}</h1>
                <div class="date">
                    <span>7min read</span>
                    <i></i>{{ date('d F Y', strtotime($post->container->published_at)) }}
                </div>
                <p>
                    @isset($parameters[\App\Models\WidgetParameters::PARAM_OPEN_TEXT])
                        {{ $parameters[\App\Models\WidgetParameters::PARAM_OPEN_TEXT] }}
                    @endisset 
                </p>
                <div class="author">   
                    <div class="img" style="background-image: url(img/content/Avatar1.jpg)"></div>
                <span>written by <span>|</span> {{ $post->author->name }}</span>
                </div>
            </div>
            <div class="col-1"></div>
            <div class="col-6">
                    @isset($parameters[\App\Models\WidgetParameters::PARAM_BG_IMAGE])
                        @php
                            $bgImage = $parameters[\App\Models\WidgetParameters::PARAM_BG_IMAGE]
                        @endphp
                    @endisset  
                <div class="img-video" style="background-image: url({{ $bgImage }})"><i class="fas fa-play-circle"></i></div>
            </div>
        </div>

    </div>
</section>
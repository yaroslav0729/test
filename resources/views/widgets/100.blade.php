<section class="blog-article-body">
    <div class="wrap">
        <div class="body"> 

        <div class="widget_layout">
            @isset($parameters[\App\Models\WidgetParameters::PARAM_HTML])
                {!! $parameters[\App\Models\WidgetParameters::PARAM_HTML] !!}
            @endisset
        </div>

        </div>
    </div>
</section>
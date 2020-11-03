<section class="blog-article-body" >
    <div class="wrap" style="background: #E9F6F8">
        <div class="body">
            <div class="blockquote">
                <i>
                    @isset($parameters[\App\Models\WidgetParameters::PARAM_OPEN_TEXT])
                        {{ $parameters[\App\Models\WidgetParameters::PARAM_OPEN_TEXT] }}
                    @endisset 
                </i>
                <div style="text-transform: uppercase">
                    @isset($parameters[\App\Models\WidgetParameters::PARAM_REFERENCE])
                        {{ $parameters[\App\Models\WidgetParameters::PARAM_REFERENCE] }}
                    @endisset 
                </div>
            </div>
        </div>
    </div>
</section>
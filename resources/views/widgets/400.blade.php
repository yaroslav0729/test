<section class="blog-article-body" >
    <div class="wrap" style="background: #E9F6F8">
        <div class="body">
            <div class="blockquote">
                <i>
                    @isset($parameters[\App\Models\WidgetParameters::PARAM_MAIN_TEXT])
                        {{ $parameters[\App\Models\WidgetParameters::PARAM_MAIN_TEXT] }}
                    @endisset 
                </i>
                <div style="text-transform: uppercase">
                    @isset($parameters[\App\Models\WidgetParameters::PARAM_ADDITIONAL_TEXT])
                        {{ $parameters[\App\Models\WidgetParameters::PARAM_ADDITIONAL_TEXT] }}
                    @endisset 
                </div>
            </div>
        </div>
    </div>
</section>
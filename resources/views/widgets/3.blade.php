<div class="blog-video" swiper-wrapper="slider-widget">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @for ($i = 0; $i < count($parameters); $i++)
                <div class="swiper-slide">
                    <div class="img-video" style="background-image: url('{{ $parameters[$i] }}')"></div>
                </div>
            @endfor
        </div>
    </div>
    <a href="#" class="view-more next swiper-button-next"><i class="moon-icons-arrow-right"></i></a>
</div>



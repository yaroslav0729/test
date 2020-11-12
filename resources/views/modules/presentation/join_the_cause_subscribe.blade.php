@php
    $title = "";
    $text = "";
    $image = "";
    
    if (isset($parameters['subscribe_title'])) {
        $title = $parameters['subscribe_title'];    
    }

    if (isset($parameters['subscribe_text'])) {
        $text = $parameters['subscribe_text'];    
    }

    if (isset($parameters['subscribe_img'])) {
        $image = $parameters['subscribe_img'];    
    }
@endphp

<section class="join-cause-2">
    <div class="wrap">
        <div>
            <div class="row align-items-center">
                <div class="col-7">
                    <div class="title mb-3">
                        <p class="font-size-30">
                            <b>
                                @if ($title === "")
                                    JOIN THE CAUSE
                                @else
                                    {{ $title }}
                                @endif
                            </b>
                        </p>
                    </div>
                    <p  class="font-size-20 mb-5">
                        @if ($text === "")
                            There are so many ways to help, make sure you stay in the loop and <a href="#" class="text-underline text-dark">sign up</a> to our Newsletter!
                        @else
                            {{ $text }}
                        @endif
                    </p>
                </div>
                <div class="col-5 pr-4">
                        @if ($image === "")
                            <img src="img/content/join-cause-2.jpg" alt="" class="w-100">
                        @else
                            <img src="img/content/{{ $image }}" alt="" class="w-100">
                        @endif
                    <i class="fal fa-plus decor-plus subscribe_news" data-toggle="modal" data-target="#subscription_modal"></i>
                </div>
            </div>
        </div>
    </div>
</section>

@include('parts.subscription_modal')
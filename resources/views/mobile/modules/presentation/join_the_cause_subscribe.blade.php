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

<section class="join-cause pb-0 with-glyph">
    <div class="wrap">
        <div class="title text-center">
            <p class="font-size-25">
                @if ($title === "")
                    JOIN THE CAUSE
                @else
                    {{ $title }}
                @endif
            </p>
        </div>
        <p class="font-size-20 mb-4  text-center">
            @if ($text === "")
                There are so many ways to help, make sure you stay in the loop and <a href="#" class="text-underline text-dark">sign up</a> to our Newsletter!
            @else
                {{ $text }}
            @endif
        </p>
        <form action="{{ route('subscribe') }}" id="subscription_form" class="d-flex mb-4" method="POST">
            @csrf
            <input type="text" name="email" placeholder="Your email address" class="flex-grow-1">
            <button type="submit" id="subscription_sbmt"><i class="far fa-chevron-right"></i></button>
        </form>
        <div class="img" style="background-image: url(img/content/join-cause-2.jpg)"></div>
    </div>
</section>
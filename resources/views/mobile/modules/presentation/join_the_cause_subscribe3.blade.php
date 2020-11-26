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
            <p class="font-size-25"><b>Join the cause!</b></p>
        </div>
        <p class="font-size-20 mb-4  text-center">
            {!! $text !!}
        </p>
        <form action="{{ route('subscribe') }}" id="subscription_form" class="d-flex mb-4" method="POST">
            @csrf
            <input type="text" name="email" placeholder="Your email address" class="flex-grow-1">
            <button type="submit" id="subscription_sbmt" ><i class="far fa-chevron-right"></i></button>
        </form>
        @if ($image === "")
            <div class="img" style="background-image: url( img/content/join-cause-2.jpg )"></div>
        @else
            <div class="img" style="background-image: url({{ $image }})"></div>
        @endif

    </div>
</section>

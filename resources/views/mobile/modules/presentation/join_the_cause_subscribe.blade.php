@php
    $title = "";
    $textBefore = "";
    $textAfter = "";
    $imageBefore = "";
    $imageAfter = "";

    if (isset($parameters['subscribe_title'])) {
        $title = $parameters['subscribe_title'];
    }

    if (isset($parameters['subscribe_text_before'])) {
        $textBefore = $parameters['subscribe_text_before'];
    }

    if (isset($parameters['subscribe_text_after'])) {
        $textAfter = $parameters['subscribe_text_after'];
    }

    if (isset($parameters['subscribe_img_before'])) {
        $imageBefore = $parameters['subscribe_img_before'];
    }

    if (isset($parameters['subscribe_img_after'])) {
        $imageAfter = $parameters['subscribe_img_after'];
    }
@endphp

<section class="join-cause pb-1 with-glyph">
    <div class="wrap">
        <div class="title text-center">
            <p class="font-size-25">
                <b>
                @empty($title)
                    Join the cause!
                @else
                    {{ $title }}
                @endif
                </b>
            </p>
        </div>
        <p  class="font-size-20 mb-4  text-center">There are so many ways to help, stay in the loop with our Newsletter.</p>
        <form action="{{ route('subscribe') }}" id="subscription_form" class="d-flex mb-4" method="POST">
            @csrf
            <input type="text" name="email" placeholder="Your email address" class="flex-grow-1">
            <button type="submit" id="subscription_sbmt" ><i class="far fa-chevron-right"></i></button>
        </form>
        @empty($disableImageBefore)
            @if ($imageBefore === "")
                <div class="img" style="background-image: url( img/content/join-cause-2.jpg )"></div>
            @else
                <div class="img" style="background-image: url({{ $imageBefore }})"></div>
            @endif
        @endempty
    </div>
</section>

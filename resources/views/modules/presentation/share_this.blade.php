@php

@endphp

<div class="share-box">
    <span>SHARE THIS</span>
    <a href="https://www.twitter.com/share?url={{ url()->current() }}"><i class="fab fa-twitter"></i></a>
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"><i class="fab fa-facebook-f"></i></a>
    <div class="stat" 
        data-token="{{ env('FACEBOOK_KEY') }}|{{ env('FACEBOOK_SECRET')}}"
        data-url="{{ url()->current() }}"
    "><span></span></div>
</div>

@php
    $cartSum = \App\Models\CartItem::getCartSum(); 
@endphp

<div class="basket @if($cartSum !== 0) bell-animate @endif" data-toggle="modal" data-target="#cartModal"><i></i>
    <span class="pulse @if($cartSum === 0) d-none @endif">£<object id="sum" >{{ $cartSum }}</object></span>
</div>
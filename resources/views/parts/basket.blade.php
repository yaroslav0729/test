@php
    $cartSum = \App\Models\CartItem::getCartSum();
@endphp

<div class="basket" data-target="#cartModal"><i></i>
    <span class="pulse @if($cartSum === 0) d-none @endif">£<object id="sum" >{{\App\Models\CartItem::roundCurrency($cartSum) }}</object></span>
</div>

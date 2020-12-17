@php

$cart = \App\Models\CartItem::getCart();
$cartSum = \App\Models\CartItem::getCartSum();

@endphp

<div class="modal fade1" id="cartModal" tabindex="-1" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">

                <div class="row align-items-center">
                    <div class="col-7">
                        <p class="font-size-20 mb-0"><b>Your donations</b></p>
                    </div>
                    <div class="col-5 text-right">
                        <div class="price">£{{ $cartSum }}</div>
                    </div>
                </div>
                <div class="black-line"></div>

                @isset($cart)
                    @foreach ($cart as $cartItem)
                        @isset($cartItem[0])
                            <div class="item">
                                <div class="row">
                                    <div class="col-8">
                                        @isset($cartItem[0]->campaign_category)
                                        <p class="font-size-20 mb-0"><b>{{ $cartItem[0]->campaign_category->name }}</b></p>
                                        @else 

                                            @empty($cartItem[0]->note)
                                                <p class="font-size-20 mb-0"><b>No category</b></p>
                                            @else
                                                <p class="font-size-20 mb-0"><b>{{ $cartItem[0]->note }}</b></p>
                                            @endempty

                                        @endisset

                                    <p class="font-size-20 mb-0">{{ (int)$cartItem[0]->period === \App\Models\CampaignPrice::TYPE_SINGLE ? 'Single' : 'Monthly' }} payment</p>
                                    </div>
                                    <div class="col-4 text-right">
                                        <form action="{{ route('cart.remove', ['itemId' => $cartItem[0]->cart_item_id]) }}" method="POST">
                                            @csrf
                                            <a href="#" class="btn-remove"><i class="fal fa-times"></i> REMOVE</a>
                                        </form>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-8"><p class="font-size-20 mb-0"><b>£ {{ $cartItem[0]->amount }}</b></p></div>
                                    <div class="col-4 text-right">
                                        <input type="number" data-id="{{ $cartItem[0]->id }}" value="{{ count($cartItem) }}" min="1" max="1000" step="1" class="color-danger"/>
                                    </div>
                                </div>
                            </div>
                        @endisset   
                    @endforeach
                @else
                    <span class="text-danger">Cart is not defined</span>
                @endisset
                

                <div class="down-bar">
                    <p><b>Thank you,</b> this donation could help empower 512 people!</p>
                    <div class="pt-3"></div>
                    <div class="row align-items-center">
                        <div class="col-7">
                            <a href="#" class="text-underline text-dark"><b>VIEW MORE PROJECTS</b></a>
                        </div>
                        <div class="col-5 text-right">
                        <a href="{{ url('/donate#about-donation') }}" class="btn_checkout btn btn-danger">Checkout <i class="moon-icons-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
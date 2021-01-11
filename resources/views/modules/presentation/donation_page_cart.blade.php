@php

$cart = \App\Models\CartItem::getCart();
$cartSum = \App\Models\CartItem::getCartSum(); 

@endphp

<section class="about-donation" id="about-donation">
    <div class="wrap">

        <div class="body no-donate">
            <div class="row align-items-center gutter-0">
                <div class="col-6">
                    <div class="row align-items-center gutter-0">
                        <div class="col-7 text-center">
                            <p class="font-size-20 mb-0"><b>Your donation so far...</b></p>
                        </div>
                        <div class="col-5 text-center">
                            <div class="price">£{{ $cartSum }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 line">
                    <p class="mb-0">No matter the amount, your support could mean everything to someone...</p>
                </div>
            </div>
        </div>

        <div class="body donated">
            <div class="row align-items-center">
                <div class="col-7">
                    <p class="font-size-20 mb-0"><b>Your donation so far...</b></p>
                </div>
                <div class="col-5 text-right">
                    <div class="price">£{{ $cartSum }}</div>
                </div>
            </div>
            <div class="black-line"></div>
            <div class="pt-4"></div>

            
            @isset($cart)
                @foreach ($cart as $cartItem)
                    @isset($cartItem[0])
                        <div class="item">
                            <div class="row gutter-0">
                                <div class="col-5">
                                    <div>
                                        <span></span>
                                        @isset($cartItem[0]->campaign)
                                        <p class="font-size-20 mb-0"><b>{{ $cartItem[0]->campaign->name }}</b></p>
                                        @endisset

                                        @isset($cartItem[0]->campaign_category)
                                        <span>+{{ $cartItem[0]->campaign_category->name }}</span>
                                        @endisset

                                        <form action="{{ route('cart.remove', ['itemId' => $cartItem[0]->cart_item_id]) }}" method="POST">
                                            @csrf
                                            <a href="#" class="btn-remove"><i class="fal fa-times"></i> REMOVE</a>
                                        </form>

                                    </div>
                                </div>
                                <div class="col-7 d-flex align-items-center">
                                    <div>
                                        <table class="w-100">
                                            <tr>
                                                <td><p class="font-size-20 mb-0">{{ (int)$cartItem[0]->period === \App\Models\CampaignPrice::TYPE_SINGLE ? 'Single' : 'Monthly' }} payment</p></td>
                                                <td><input type="number" input_number_spinner data-id="{{ $cartItem[0]->id }}" value="{{ count($cartItem) }}" min="0" max="1000" step="1" class="color-danger"/></td>
                                                <td class="text-right"><p class="font-size-20 mb-0"><b>£{{ $cartItem[0]->amount }}</b></p></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endisset
                @endforeach
            @endisset

            @isset($cart)
                @if(count($cart))
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <a id="clear_all_btn"><i class="fal fa-times"></i> Remove all items</a>
                    </form>
                @endif
            @endisset

            <div class="pt-4"></div>
            <div class="down-bar">
                <div class="row align-items-center">
                    <div class="col-7">
                        <p>Thank you for donation!</p>
                    </div>
                    <div class="col-5 text-right">
                        <a href="{{ route('cart.payment') }}" class="btn  btn-danger">Checkout <i class="moon-icons-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mb-4">
            <img src="img/payments-image.png" alt="" class="img-fluid">
        </div>

        
    </div>
</section>
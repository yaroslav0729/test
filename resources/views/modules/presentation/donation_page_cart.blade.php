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
                    <div class="item">
                        <div class="row gutter-0">
                            <div class="col-5">
                                <div>
                                    <span></span>
                                    <p class="font-size-20 mb-0"><b>{{ $cartItem->campaign_category->name }}</b></p>

                                    <form action="{{ route('cart.remove', ['itemId' => $cartItem->cart_item_id]) }}" method="POST">
                                        @csrf
                                        <a href="#" class="btn-remove"><i class="fal fa-times"></i> REMOVE</a>
                                    </form>

                                </div>
                            </div>
                            <div class="col-7 d-flex align-items-center">
                                <div>
                                    <table class="w-100">
                                        <tr>
                                            <td><p class="font-size-20 mb-0">{{ (int)$cartItem->period === \App\Models\CampaignPrice::TYPE_SINGLE ? 'Single' : 'Monthly' }} payment</p></td>
                                            <td><input type="number" value="1" min="0" max="1000" step="1" class="color-danger"/></td>
                                            <td class="text-right"><p class="font-size-20 mb-0"><b>£{{ $cartItem->amount }}</b></p></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endisset

            <div class="pt-4"></div>
            <div class="down-bar">
                <div class="row align-items-center">
                    <div class="col-7">
                        <p>Thank you, this donation could help empower 512 people!</p>
                    </div>
                    <div class="col-5 text-right">
                        <a href="#" class="btn  btn-danger">Checkout <i class="far fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>


        <div class="text-center mb-4">
            <img src="img/payments-image.png" alt="" class="img-fluid">

        </div>
    </div>
</section>
@php
    $cart = \App\Models\CartItem::getCart();
    $cartSum = \App\Models\CartItem::getCartSum();
@endphp

<section class="about-donation" id="about-donation">
    <div class="wrap">

        @if($cartSum === 0)
        <div class="body no-donate">
            <div class="row align-items-center gutter-0">
                <div class="col-12 col-lg-7">
                    <div class="row align-items-center gutter-0">
                        <div class="col-7">
                            <p class="font-size-20 mb-0 letter-spacing-0"><b>Your donation so far...</b></p>
                        </div>
                        <div class="col-5 text-center">
                            <div class="price">£{{\App\Models\CartItem::roundCurrency($cartSum) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5 line relative">
                    <p class="mb-0">No matter the amount, your support could mean everything to someone...</p>
                </div>
            </div>
        </div>
        @else
        <div class="body donated">
            <div class="row align-items-center">
                <div class="col-7">
                    <p class="font-size-20 mb-0 letter-spacing-0"><b>Your donation so far...</b></p>
                </div>
                <div class="col-5 text-right">
                    <div class="price">£{{ \App\Models\CartItem::roundCurrency($cartSum) }}</div>
                </div>
            </div>
            <div class="black-line"></div>
            <div class="pt-4"></div>

                @isset($cart)
                    @foreach ($cart as $cartItem)
                        @isset($cartItem[0])
                            @php
                                $collection = \Illuminate\Database\Eloquent\Collection::make($cartItem);
                            @endphp
                            @isset($cartItem[0]->campaign)
                                @php
                                    $grouped = $collection->groupBy('campaign.name');
                                @endphp
                            @endisset
                            @isset($cartItem[0]->foodpack)
                                @php
                                    $grouped = $collection->groupBy('foodpack.country.name');
                                @endphp
                            @endisset
                            @isset($cartItem[0]->foodpackqurbani)
                                @php
                                    $grouped = $collection->groupBy('foodpackqurbani.country.name');
                                @endphp
                            @endisset
                            @isset($cartItem[0]->campaign_category)
                                @php
                                    $grouped = $collection->groupBy('campaign_category.name');
                                @endphp
                            @endisset
                            @foreach($grouped as $name => $items)
                                @php
                                    $firstItem = $items->first();
                                @endphp
                                <div class="item">
                                    <div class="row gutter-0">
                                        <div class="col-5">
                                            <div>
                                                <span></span>

                                                @isset($firstItem->campaign)
                                                    <p class="font-size-20 mb-0 letter-spacing-0">
                                                        <b>{{ $name }}</b>
                                                    </p>
                                                @endisset

                                                @isset($firstItem->foodpack)
                                                    <p class="font-size-20 mb-0 letter-spacing-0">
                                                        <b>{{ $name }} FoodPack</b>
                                                    </p>
                                                @endisset

                                                @isset($firstItem->foodpackqurbani)
                                                    <p class="font-size-20 mb-0 letter-spacing-0">
                                                        <b>{{ $name }} Qurbani ({{ $firstItem->foodpackqurbanitype->name }})</b>
                                                    </p>
                                                @endisset

                                                @isset($firstItem->campaign_category)
                                                    <span>+{{ $name }}</span>
                                                @endisset

                                                <form
                                                    action="{{ route('cart.remove', ['itemId' => $firstItem->cart_item_id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <a href="#" class="btn-remove"><i class="fal fa-times"></i>
                                                        REMOVE
                                                    </a>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-7 d-flex align-items-center">
                                            <div>
                                                <table class="w-100">
                                                    <tr>
                                                        <td style="width: 220px">
                                                            <p class="font-size-20 mb-0 letter-spacing-0">
                                                                {{ (int)$firstItem->period === \App\Models\CampaignPrice::TYPE_SINGLE ? 'Single' : 'Monthly' }} payment
                                                            </p>
                                                        </td>
                                                        <td class="text-center">
                                                            <input
                                                                type="number"
                                                                input_number_spinner
                                                                data-id="{{ $firstItem->id }}"
                                                                value="{{ $items->count() }}"
                                                                min="0"
                                                                max="1000"
                                                                step="1"
                                                                class="cart-compaign-count color-danger"
                                                            />
                                                        </td>
                                                        <td style="width: 100px" class="text-right">
                                                            <p class="font-size-20 mb-0">
                                                                <b>£{{ \App\Models\CartItem::roundCurrency($firstItem->amount) }}</b>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
                        <p>Thank you, your donation will help empower people in need!</p>
                    </div>
                    <div class="col-5 text-right">
                        <a href="{{ route('cart.payment') }}" class="btn  btn-danger">Checkout <i class="moon-icons-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="text-center mb-4">
            <img src="img/payments-image.png?1" alt="" class="img-fluid d-inline-block" style="max-width: 570px">
        </div>
    </div>
</section>

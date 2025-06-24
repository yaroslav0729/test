@extends('layouts.main')

@section('header')
    @include('parts.header')
@endsection

@section('scripts')
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('googlemap.map_key') }}&libraries=places&language=EN"
        defer>
    </script>
    @if(Setting::get(Setting::ENABLE_STRIPE))
        <script src="https://js.stripe.com/v3/"></script>
    @endif
    {!! NoCaptcha::renderJs() !!}

    <style>
        /* Ensure payment request button is visible */
        #payment-request-button {
            min-height: 48px;
            margin-bottom: 20px;
        }

        /* Ensure proper spacing */
        #payment-request-divider {
            margin: 20px 0;
            text-align: center;
        }
    </style>
@endsection


@section('content')

    @php
    $cart = \App\Models\CartItem::getCart();
    $cartSum = \App\Models\CartItem::getCartSum();
    $hasSingleDonations = \App\Models\CartItem::hasSingleDonations();
    $hasMonthlyDonations = \App\Models\CartItem::hasMonthlyDonations();
    @endphp

    <div class="donated-page">
        <section class="box">
            <div class="wrap">
                <form id="payment-form" action="{{ route('cart.order') }}" method="POST">
                    @csrf
                    <p class="font-size-30 mb-5"><b>Payment details</b></p>
                    <div class="text-right pb-3"><b>YOUR DETAILS</b></div>
                    <div class="black-line"></div>
                    <div class="pt-5"></div>
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-5">
                            <div class="form-group">
                                <label><b>TITLE</b> (OPTIONAL)</label>
                                <select class="form-control" name="title">
                                    <option value="mr">Mr</option>
                                    <option value="mrs">Mrs</option>
                                    <option value="miss">Miss</option>
                                    <option value="ms">Ms</option>
                                    <option value="dr">Dr</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label class="@error('first_name') text-danger @enderror"><b>FIRST NAME</b></label>
                                <input type="text" name="first_name" placeholder="Enter first name..."
                                    class="form-control @error('first_name') border-danger @enderror"
                                    value="{{ old('first_name') }}">
                            </div>
                            @error('first_name')
                                <p class="text-danger ml-3 font-size-14">*{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="pt-3"></div>
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-5">
                            <div class="form-group">
                                <label class="@error('last_name') text-danger @enderror"><b>LAST NAME</b></label>
                                <input type="text" name="last_name" placeholder="Enter last name..."
                                    class="form-control @error('last_name') border-danger @enderror"
                                    value="{{ old('last_name') }}">
                            </div>
                            @error('last_name')
                                <p class="text-danger ml-3 font-size-14">*{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label class="@error('email') text-danger @enderror"><b>EMAIL</b></label>
                                <input type="text" name="email" placeholder="enter email"
                                    class="form-control @error('email') border-danger @enderror"
                                    value="{{ old('email') }}">
                            </div>
                            @error('email')
                                <p class="text-danger ml-3 font-size-14">*{{ $message }}</p>
                            @enderror
                            <div class="text-right">
                                <label class="checkbox rPos">
                                    <input type="checkbox" value="1" name="do_email"><span><i
                                            class="fal fa-check"></i></span>
                                    <b>Stay up to date, Subscribe to our Newsletter!</b>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="pt-5"></div>

                    <div class="text-right pb-3"><b>ADDRESS & CONTACT</b></div>
                    <div class="black-line height-1"></div>
                    <div class="pt-5"></div>
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-5">
                            <div class="form-group postcode-finder-container">
                                <label><b>ENTER YOUR POSTCODE</b></label>
                                <input type="text" id="postcode-finder" class="form-control" name="some_adr"
                                    autocomplete="off" placeholder="Type postcode...">

                                <div id="postcode-results" class="postcode-results d-none">

                                </div>
                            </div>
                            <div class="text-right">
                                <a href="#" class="toggle-manual-address font-size-12 text-dark">OR ENTER MANUALLY <i
                                        class="far fa-chevron-down"></i></a>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label><b>CONTACT NUMBER</b> (OPTIONAL)</label>
                                <input type="text" placeholder="Enter the phone number..." name="phone"
                                    class="form-control">
                            </div>
                            <div class="text-right">
                                <label class="checkbox rPos">
                                    <input type="checkbox" name="do_sms" value="1"><span><i class="fal fa-check"></i></span>
                                    <b>Send me occasional SMS updates</b>
                                </label>
                            </div>
                            <div class="text-right">
                                <label class="checkbox rPos">
                                    <input type="checkbox" name="do_post" value="1"><span><i
                                            class="fal fa-check"></i></span>
                                    <b>Send me postal marketing</b>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="manual-address" style="display: block">
                        <div class="pt-3"></div>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-5">
                                <div class="form-group">
                                    <label class="@error('address_1') text-danger @enderror"><b>ADDRESS</b> (LINE
                                        1)</label>
                                    <input type="text" id="route" name="address_1" placeholder="Enter the address..."
                                        class="form-control auto-address @error('address_1') border-danger @enderror"
                                        value="{{ old('address_1') }}">
                                </div>
                                @error('address_1')
                                    <p class="text-danger ml-3 font-size-14">*{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <label><b>ADDRESS</b> (LINE 2)</label>
                                    <input type="text" name="address_2" placeholder="Enter the address..."
                                        class="form-control auto-address" value="{{ old('address_2') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-5">
                                <div class="form-group">
                                    <label class="@error('city') text-danger @enderror"><b>CITY</b></label>
                                    <input type="text" id="postal_town" name="city" placeholder="Enter the city..."
                                        class="form-control auto-address @error('city') border-danger @enderror"
                                        value="{{ old('city') }}">
                                </div>
                                @error('city')
                                    <p class="text-danger ml-3 font-size-14">*{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <label><b>COUNTY</b></label>
                                    <input type="text" id="administrative_area_level_2" class="form-control auto-address"
                                        name="county" value="{{ old('county') }}">
                                </div>
                            </div>
                        </div>
                        <div class="pt-3"></div>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-5">
                                <div class="form-group">
                                    <label class="@error('post_code') text-danger @enderror"><b>POST CODE</b></label>
                                    <input type="text" id="postal_code"
                                        class="form-control auto-address @error('post_code') border-danger @enderror"
                                        name="post_code" placeholder="Enter postcode..." value="{{ old('post_code') }}">
                                </div>
                                @error('post_code')
                                    <p class="text-danger ml-3">*{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <label><b>COUNTRY</b></label>
                                    <select class="form-control" id="country" name="country">
                                        @foreach (\App\Models\Country::getAllEnabled() as $country)
                                            <option value="{{ $country->id }}" @if (old('country'))  @if ($country->id==old('country'))
                                                selected="selected" @endif
                                            @else
                                                @if ($country->id == 187)
                                                    selected="selected"
                                                @endif
                                        @endif >
                                        {{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="pt-3"></div>

                    </div>
                    <div class="pt-5"></div>

                    @isset($cart)
                        <div id="qurbani-names" class="">
                            <div class="text-right pb-3"><b>DONATION NOTES (ON BEHALF OF)</b></div>
                            <div class="black-line"></div>
                            <div class="pt-5"></div>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <div id="donation-notes">
                                @foreach($cart as $group)
                                    @foreach($group as $cartItem)
                                        @continue($cartItem->upsell)
                                        @php
                                            if(isset($cartItem->campaign)){
                                                $donationName =  $cartItem->campaign->name;
                                            } else  if(isset($cartItem->foodpack)){
                                                $donationName =  $cartItem->foodpack->country->name. " FoodPack";
                                            } else  if(isset($cartItem->foodpackqurbani)){
                                                $donationName =  $cartItem->foodpackqurbani->country->name. " Qurbani (" . $cartItem->foodpackqurbanitype->name . ")";
                                            } else {
                                                $donationName = 'Quick Donation (' . ($cartItem->period === \App\Models\Donation::TYPE_MONTHLY ? 'Monthly' : 'Single') . ')';
                                            }
                                            $isWater = str_contains($donationName, 'water') || str_contains($donationName, 'Water');
                                            @endphp
                                        <div class="d-flex" style="width: 100%; gap: 10px;">
                                            <div class="form-group" @if($isWater) style="width: 70%;" @else style="width: 100%;" @endif data-cart_item_id="{{ $cartItem->cart_item_id }}">
                                                <label class="@error('notes_' . $cartItem->cart_item_id) text-danger @enderror">Notes for {{ $donationName }} £{{ $cartItem->amount }}</label>
                                                <input class="form-control @error('notes_' . $cartItem->cart_item_id) border-danger @enderror" name="notes_{{ $cartItem->cart_item_id }}" required="" maxlength="70" placeholder="Please insert any names here. 70 characters max.">
                                            </div>
                                            @if($isWater)
                                            <div class="form-group" style="width: 30%;">
                                                <label class="@error('donated_by_' . $cartItem->cart_item_id) text-danger @enderror">Donated by</label>
                                                <input class="form-control @error('donated_by_' . $cartItem->cart_item_id) border-danger @enderror" name="donated_by_{{ $cartItem->cart_item_id }}" required="" value="Anonymous" maxlength="70" placeholder="Please insert any names here. 70 characters max.">
                                            </div>
                                            @endif
                                        </div>
                                        @error('notes_' . $cartItem->cart_item_id)
                                            <p class="text-danger ml-3">*{{ $message }}</p>
                                        @enderror
                                    @endforeach
                                @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pt-5"></div>
                    @endisset

                    <div class="text-right pb-3"><b>OTHER NOTES (OPTIONAL)</b></div>
                    <div class="black-line height-1"></div>
                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-10">
                            <div class="form-group">
                                <div class="pt-5"></div>
                                <label><b>NOTE</b></label>
                                {{-- <textarea rows="1" name="notes" class="form-control"></textarea> --}}
                                <span class="string-counter">0/34</span>
                                <input type="text" class="form-control" placeholder="Please add any other notes here (optional)" name="notes" value="{{ old('notes') }}" maxlength="70">
                            </div>
                        </div>
                    </div>
                    <div class="pt-5"></div>

                    <div class="gift-aid-sheet">
                        <div class="mb-4"><img src="/img/Gift-aid-logo-white.png" alt="" class="img-fluid"></div>
                        <div class="pl-4 pr-4 mb-4">
                            <p class="font-size-20 text-white"><b>Make your donation go 25% further, for free!</b></p>
                            <p class="font-size-16 text-white">If you are a UK taxpayer, the value of your gift can be
                                increased by 25% under the Gift Aid scheme at no extra cost to you. For example with
                                Gift Aid, for every £1 you donate we'll receive £1.25, and it doesn't cost you a
                                penny.</p>
                        </div>
                        <br>
                        <div class="bg pl-4 pr-4">
                            <label class="checkbox">
                                <input type="checkbox" name="gift_aid" value="1"><span><i class="fal fa-check"></i></span>
                                <b>Yes, I am a UK taxpayer and would like Islamic Help to treat all donations I have
                                    made over the past four years and all donations I make in the future (unless I
                                    notify you otherwise) as Gift Aid donations.</b>
                            </label>
                        </div>
                    </div>
                    <div class="pt-5"></div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="toggle-view-donation letter-spacing-1">
                                <b class="mr-4">£{{ $cartSum }}</b>
                                <span class="cursor-pointer toggle-view-donation-info">VIEW SUMMARY <i
                                        class="ml-2 far fa-chevron-down"></i></span>
                            </div>
                            <span class=" cursor-pointer toggle-view-donation-info letter-spacing-1">CLOSE SUMMARY <i
                                    class="ml-2 far fa-chevron-up"></i></span>
                        </div>
                        <div class="col-6 text-right letter-spacing-1"><b>PAYMENT DETAIL</b></div>
                    </div>

                    <div class="black-line height-1"></div>

                    <div class="row gutter-0">
                        <div class="col-6 info-col">
                            <div id="donate-page-cart" class="order-cart-list">
                                @isset($cart)
                                    @foreach ($cart as $cartItem)
                                        @isset($cartItem[0])
                                            <div class="item">
                                                <div class="row">
                                                    <div class="col-7">
                                                        @isset($cartItem[0]->upsell)
                                                            <p class="font-size-20 mb-0 letter-spacing-0">
                                                                <b>{{ $cartItem[0]->name }}</b>
                                                            </p>
                                                        @endisset
                                                        @isset($cartItem[0]->campaign_category)
                                                            <p class="font-size-20 mb-0 letter-spacing-0">
                                                                <b>{{ $cartItem[0]->campaign_category->name }}</b>
                                                            </p>
                                                        @endisset
                                                        @isset($cartItem[0]->foodpack)
                                                            <p class="font-size-20 mb-0 letter-spacing-0">
                                                                <b>{{ $cartItem[0]->foodpack->country->name }} FoodPack</b>
                                                            </p>
                                                        @endisset
                                                        @isset($cartItem[0]->foodpackqurbani)
                                                            <p class="font-size-20 mb-0 letter-spacing-0">
                                                                <b>{{ $cartItem[0]->foodpackqurbani->country->name }} Qurbani ({{ $cartItem[0]->foodpackqurbanitype->name }})</b>
                                                            </p>
                                                        @endisset
                                                        @isset($cartItem[0]->campaign)
                                                            <p class="font-size-20 mb-0 letter-spacing-0">
                                                                <b>{{ $cartItem[0]->campaign->name }}</b>
                                                            </p>
                                                        @endisset
                                                        <p class="font-size-20 mb-0 letter-spacing-0">
                                                            {{ (int) $cartItem[0]->period === \App\Models\CampaignPrice::TYPE_SINGLE ? 'Single' : 'Monthly' }}
                                                            payment</p>
                                                    </div>
                                                    <div class="col-5 text-right">
                                                        <form
                                                            action="{{ route('cart.remove', ['itemId' => $cartItem[0]->cart_item_id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" value="{{ $cartItem[0]->project_id ?? '' }}"
                                                                class="project">
                                                            <a href="#" class="btn-remove"><i class="fal fa-times"></i> REMOVE</a>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="row align-items-center">
                                                    <div class="col-7">
                                                        <p class="font-size-20 mb-0">
                                                            <b>£{{ \App\Models\CartItem::roundCurrency($cartItem[0]->amount) }}</b>
                                                        </p>
                                                    </div>
                                                    <div class="col-5 text-right"><input type="number" input_number_spinner
                                                            data-id="{{ $cartItem[0]->id }}" value="{{ count($cartItem) }}"
                                                            min="1" max="1000" step="1" class="color-danger" /></div>
                                                </div>
                                            </div>
                                        @endisset
                                    @endforeach
                                @endisset
                                {{-- <div class="item">
                                    <div class="row">
                                        <div class="col-7">
                                            <p class="font-size-20 mb-0 letter-spacing-0"><b>General Charity</b></p>
                                            <p class="font-size-20 mb-0 letter-spacing-0">Single payment</p>
                                        </div>
                                        <div class="col-5 text-right"><a href="#" class="btn-remove"> <i
                                                    class="fal fa-times"></i> REMOVE</a></div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-7">
                                            <p class="font-size-20 mb-0"><b>£50.00</b></p>
                                        </div>
                                        <div class="col-5 text-right"><input type="number" value="1" min="0" max="1000"
                                                step="1" class="color-danger" /></div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-7">
                                            <p class="font-size-20 mb-0 letter-spacing-0"><b>General Charity</b></p>
                                            <p class="font-size-20 mb-0 letter-spacing-0">Single payment</p>
                                            <span>+Sadiqah</span>
                                        </div>
                                        <div class="col-5 text-right"><a href="#" class="btn-remove"> <i
                                                    class="fal fa-times"></i> REMOVE</a></div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-7">
                                            <p class="font-size-20 mb-0"><b>£50.00</b></p>
                                        </div>
                                        <div class="col-5 text-right"><input type="number" value="1" min="0" max="1000"
                                                step="1" class="color-danger" /></div>
                                    </div>
                                </div> --}}
                                <div class="pt-5"></div>
                                <div class="total">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <b>DONATION TOTAL:</b>
                                        </div>
                                        <div class="col-6">
                                            <span>£<span id="page-sum" class="d-inline">{{ $cartSum }}</span></span>
                                        </div>
                                    </div>
                                    <div class="row align-items-center" id="stripe-fee" style="display: none;">
                                        <div class="col-6">
                                            <b>Payment processing fees:</b>
                                        </div>
                                        <div class="col-6">
                                            <span>£<span id="page-sum-fee" class="d-inline">{{ \App\Services\StripeService::countCommission($cartSum) }}</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 card-col">
                            <div>
                                <div class="pt-4"></div>
                                @if ($hasSingleDonations)
                                    <div class="mb-4 text-center">
                                        <label class="radio mr-5">
                                            <input type="radio" name="pay_method" checked
                                                   value="{{Setting::get(Setting::ENABLE_STRIPE)?'stripe':'global' }}"><span><i
                                                    class="fal fa-check"></i></span>
                                            <b>PAY BY CARD</b>
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="pay_method" value="paypal"><span><i
                                                    class="fal fa-check"></i></span>
                                            <b>PAY BY PAYPAL</b>
                                        </label>
                                    </div>
                                    @if(Setting::get(Setting::ENABLE_STRIPE))
{{--                                    <div class="mb-4 text-center" style="display: none" id="stripe-checkbox">--}}
{{--                                        <label class="checkbox">--}}
{{--                                            <input type="checkbox" name="stripe_fee"><span><i--}}
{{--                                                        class="fal fa-check"></i></span>--}}
{{--                                            <b style="font-size: 15px">I'm happy to cover the payment processing fees <b id="commission">{{ '(+£' . \App\Services\StripeService::countCommission($cartSum) . ')' }}</b></b>--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
                                    @endif
                                @endif

                                @if(Setting::get(Setting::ENABLE_STRIPE))
                                    <!-- Google Pay / Apple Pay Button -->
                                    <div id="payment-request-button" style="display: none; margin-bottom: 20px;">
                                        <!-- Payment request button will be inserted here -->
                                    </div>

                                    <!-- Google Pay button (Chrome on iOS) -->
                                    <div id="google-pay-button" style="display: none; margin-bottom: 20px;"></div>

                                    <!-- OR divider -->
                                    <div id="payment-request-divider" style="display: none; text-align: center; margin: 20px 0;">
                                        <span style="background: white; padding: 0 15px; color: #666;">OR</span>
                                        <hr style="margin-top: -12px; border-color: #ddd;">
                                    </div>
                                @endif

                                <div id="card-payment-container">
                                    @if(Setting::get(Setting::ENABLE_STRIPE))
                                        <div class="form-group">
                                            <label><b>CARD DETAILS</b></label>
                                            <div class="mb-3">
                                                <label class="form-label">Card Number</label>
                                                <div id="card-number-element" style="padding: 10px; border: 1px solid #ced4da; border-radius: 4px;">
                                                    <!-- Card number element will be inserted here -->
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="form-label">Expiry Date</label>
                                                    <div id="card-expiry-element" style="padding: 10px; border: 1px solid #ced4da; border-radius: 4px;">
                                                        <!-- Card expiry element will be inserted here -->
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">CVC</label>
                                                    <div id="card-cvc-element" style="padding: 10px; border: 1px solid #ced4da; border-radius: 4px;">
                                                        <!-- Card CVC element will be inserted here -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <label class="form-label">Postal Code</label>
                                                <div id="postal-code-element" style="padding: 10px; border: 1px solid #ced4da; border-radius: 4px;">
                                                    <!-- Postal code element will be inserted here -->
                                                </div>
                                            </div>
                                            <!-- Used to display form errors. -->
                                            <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <label><b>CARD NUMBER</b></label>
                                            <input type="text" class="form-control" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19" required>
                                        </div>
                                        <div class="form-group">
                                            <label><b>EXPIRY DATE</b></label>
                                            <input type="text" class="form-control" name="expiry_date" placeholder="MM / YY" maxlength="7" required>
                                        </div>
                                        <div class="form-group">
                                            <label><b>CVV</b></label>
                                            <input type="text" class="form-control" name="cvv" placeholder="123" maxlength="3" required>
                                        </div>
                                    @endif
                                </div>

                                @if ($hasMonthlyDonations && !Setting::get(Setting::ENABLE_STRIPE))
                                    <div class="row">
                                        <div class="form-group pr-2">
                                            <label><b>Account Number*</b></label>
                                            <input class="form-control" name="account_number" required
                                                placeholder="Enter Account Number">
                                        </div>
                                        <div class="form-group px-2">
                                            <label><b>Sort Code*</b></label>
                                            <input class="form-control" name="sort_code" required
                                                placeholder="Enter Sort Code">
                                        </div>
                                        <div class="form-group pl-2">
                                            <label><b>Pay Day*</b></label>
                                            <select class="form-control" name="pay_day">
                                                <option value="8">8th day of month</option>
                                                <option value="Last working day of the month">Last working day of the month
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                <div style="margin-right:auto;margin-left:auto;display:table;">
                                    {!! NoCaptcha::display() !!}

                                    @if ($errors->has('g-recaptcha-response'))
                                        <p class="text-danger ml-3 font-size-14">{{ $errors->first('g-recaptcha-response') }}</p>
                                    @endif
                                </div>

                                <button type="submit" id="cart-pay" class="btn btn-danger border-white btn-submit">
                                    <span id="button-text">Pay Now</span>
                                    <div id="spinner" class="spinner-border spinner-border-sm text-light d-none" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <!-- Card Payment Modal -->
    <div class="modal fade" id="cardPaymentModal" tabindex="-1" role="dialog" aria-labelledby="cardPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cardPaymentModalLabel">Card Payment Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if(Setting::get(Setting::ENABLE_STRIPE))
                        <form id="card-payment-form">
                            <div class="form-group">
                                <label><b>CARD DETAILS</b></label>
                                <div id="card-element" style="padding: 10px; border: 1px solid #ced4da; border-radius: 4px;">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>
                                <!-- Used to display form errors. -->
                                <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                            </div>
                            <button type="submit" class="btn btn-danger w-100" id="submit-payment">
                                <span id="button-text">Pay Now</span>
                                <div id="spinner" class="spinner-border spinner-border-sm text-light d-none" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </button>
                        </form>
                    @else
                        <form id="card-payment-form">
                            <div class="form-group">
                                <label><b>CARD NUMBER</b></label>
                                <input type="text" class="form-control" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19" required>
                            </div>
                            <div class="form-group">
                                <label><b>EXPIRY DATE</b></label>
                                <input type="text" class="form-control" name="expiry_date" placeholder="MM / YY" maxlength="7" required>
                            </div>
                            <div class="form-group">
                                <label><b>CVV</b></label>
                                <input type="text" class="form-control" name="cvv" placeholder="123" maxlength="3" required>
                            </div>
                            <button type="submit" class="btn btn-danger w-100">Pay Now</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

<script>
    // Stripe configuration
    @if(Setting::get(Setting::ENABLE_STRIPE))
    window.stripe_enabled = true;
    window.stripe_public_key = '{{ config('stripe.public_key') }}';
    @else
    window.stripe_enabled = false;
    @endif
</script>
@endsection

@extends('layouts.main')

@section('header')
    @include('parts.header')
@endsection

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&libraries=places&language=EN" defer>
    </script>
    {!! NoCaptcha::renderJs() !!}
@endsection

@section('content')

    @php
        $cart = \App\Models\CartItem::getCart();
        $hasSingleDonations = \App\Models\CartItem::hasSingleDonations();
        $hasMonthlyDonations = \App\Models\CartItem::hasMonthlyDonations();
    @endphp

    <div class="donated-page">
        <form id="payment-form" action=" {{ route('cart.order') }}" method="POST">
            @csrf
            <p class="font-size-16 mb-3"><b>Payment details</b></p>
            <div class="form-title"><b>YOUR DETAILS</b><i class="fal fa-check-circle"></i></div>
            <div>
                <div class="form-group">
                    <label><b>TITLE</b> (OPTIONAL)</label>
                    <select class="form-control" name="title">
                        <option value="mr">Mr</option>
                        <option value="mrs">Mrs</option>
                        <option value="miss">Miss</option>
                        <option value="dr">Dr</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="@error('first_name') text-danger @enderror"><b>FIRST NAME</b></label>
                    <input type="text" name="first_name" class="form-control @error('first_name') border-danger @enderror"
                        value="{{ old('first_name') }}">
                </div>
                @error('first_name')
                    <p class="text-danger ml-3 font-size-14">*{{ $message }}</p>
                @enderror
                <div class="form-group">
                    <label class="@error('last_name') text-danger @enderror"><b>LAST NAME</b></label>
                    <input type="text" name="last_name" class="form-control @error('last_name') border-danger @enderror"
                        value="{{ old('last_name') }}">
                </div>
                @error('last_name')
                    <p class="text-danger ml-3 font-size-14">*{{ $message }}</p>
                @enderror
                <div class="form-group">
                    <label class="@error('email') text-danger @enderror"><b>EMAIL</b></label>
                    <input type="text" name="email" class="form-control @error('email') border-danger @enderror"
                        value="{{ old('email') }}">
                </div>
                @error('email')
                    <p class="text-danger ml-3 font-size-14">*{{ $message }}</p>
                @enderror
                <div>
                    <label class="checkbox">
                        <input type="checkbox" value="1" name="do_email"><span><i class="fal fa-check"></i></span>
                        <b>Subscribe to our Newsletter!</b>
                    </label>
                </div>
                <div class="pt-5"></div>
            </div>

            <div class="form-title"><b>ADDRESS & CONTACTS</b></div>
            <div>
                <div class="form-group postcode-finder-container">
                    <label><b>ENTER YOUR POSTCODE</b></label>
                    <input type="text" id="postcode-finder" name="postcode" class="form-control"
                        placeholder="Type postcode..." autocomplete="off">

                    <div id="postcode-results" class="postcode-results d-none">

                    </div>
                </div>
                <div class="text-right">
                    <a href="#" class="toggle-manual-address font-size-12 text-dark"><b>OR ENTER MANUALLY</b> <i
                            class="far fa-chevron-down"></i></a>
                </div>
                <div class="pt-3"></div>

                <div class="form-group">
                    <label><b>CONTACT NUMBER</b> (OPTIONAL)</label>
                    <input type="text" name="phone" class="form-control">
                </div>
                <div>
                    <label class="checkbox">
                        <input type="checkbox" name="do_sms" value="1"><span><i class="fal fa-check"></i></span>
                        <b>Send me occasional SMS updates</b>
                    </label>
                </div>
                <div>
                    <label class="checkbox">
                        <input type="checkbox" name="do_post" value="1"><span><i class="fal fa-check"></i></span>
                        <b>Send me postal marketing</b>
                    </label>
                </div>
                <div class="manual-address" style="display: block">
                    <div class="pt-3"></div>
                    <div class="form-group">
                        <label class="@error('address_1') text-danger @enderror"><b>ADDRESS</b> (LINE 1)</label>
                        <input type="text" id="route" name="address_1"
                            class="form-control auto-address @error('address_1') border-danger @enderror"
                            value="{{ old('address_1') }}">
                    </div>
                    @error('address_1')
                        <p class="text-danger ml-3 font-size-14">*{{ $message }}</p>
                    @enderror
                    <div class="form-group">
                        <label><b>ADDRESS</b> (LINE 2)</label>
                        <input type="text" name="address_2" class="form-control auto-address"
                            value="{{ old('address_2') }}">
                    </div>
                    <div class="form-group">
                        <label class="@error('city') text-danger @enderror"><b>CITY</b></label>
                        <input type="text" id="postal_town" name="city"
                            class="form-control auto-address @error('city') border-danger @enderror"
                            value="{{ old('city') }}">
                    </div>
                    @error('city')
                        <p class="text-danger ml-3 font-size-14">*{{ $message }}</p>
                    @enderror
                    <div class="form-group">
                        <label><b>COUNTY</b></label>
                        <input type="text" id="administrative_area_level_2" name="county" class="form-control auto-address"
                            value="{{ old('county') }}">
                    </div>
                    <div class="form-group">
                        <label><b>COUNTRY</b></label>
                        <select class="form-control" id="country" name="country">
                            @foreach (\App\Models\Country::getAllEnabled() as $country)
                                <option value="{{ $country->id }}" @if (old('country'))
                                    @if ($country->id == old('country'))
                                        selected="selected" @endif
                                @else
                                    @if ($country->id == 187)
                                        selected="selected"
                                    @endif
                            @endif >{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="@error('post_code') text-danger @enderror"><b>POST CODE</b></label>
                        <input type="text" id="postal_code" name="post_code"
                            class="form-control auto-address @error('post_code') border-danger @enderror"
                            value="{{ old('post_code') }}">
                    </div>
                    @error('post_code')
                        <p class="text-danger ml-3">*{{ $message }}</p>
                    @enderror
                </div>
                <div class="pt-5"></div>
            </div>

            @isset($cart)
                <div id="qurbani-names" class="">
                    <div class="text-right pb-3"><b>DONATION NOTES</b></div>
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
                                            $donationName = 'Quick Donation (' . ($cartItem->period === \App\Models\Donation::TYPE_MONTHLY ? 'Monthly' : 'Single') . ')';
                                            if(isset($cartItem->campaign)){
                                                $donationName =  $cartItem->campaign->name;
                                            } else  if(isset($cartItem->foodpack)){
                                                $donationName =  $cartItem->foodpack->country->name. " FoodPack";
                                            } else  if(isset($cartItem->foodpackqurbani)){
                                                $donationName =  $cartItem->foodpackqurbani->country->name. " Qurbani (" . $cartItem->foodpackqurbanitype->name . ")";
                                            }
                                        @endphp
                                        <div class="form-group" data-cart_item_id="{{ $cartItem->cart_item_id }}">
                                            <label class="@error('notes_' . $cartItem->cart_item_id) text-danger @enderror">Notes for {{ $donationName }} £{{ $cartItem->amount }}</label>
                                            <input class="form-control @error('notes_' . $cartItem->cart_item_id) border-danger @enderror" name="notes_{{ $cartItem->cart_item_id }}" required="" maxlength="25" placeholder="Please insert any names here. 25 characters max.">
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

            <div class="form-title"><b>OTHER NOTES (OPTIONAL)</b></div>
            <div>
                <div class="form-group">
                    <label><b>NOTE</b> (ON BEHALF OF)</label>
                    <span class="string-counter">0/34</span>
                    <textarea name="notes" rows="1" class="form-control" value="{{ old('notes') }}"
                        maxlength="25" placeholder="Please insert any names here. 25 characters max."></textarea>
                </div>
                <div class="pt-5"></div>
            </div>

            <div class="gift-aid-sheet">
                <div class="mb-4 text-right"><img src="/img/Gift-aid-logo-white.png" alt="" class="img-fluid"></div>
                <div class="pl-4 pr-4 mb-4">
                    <p class="font-size-25 text-white"><b>Make your donation go 25% further, for free!</b></p>
                    <p class="font-size-16 text-white">If you are a UK taxpayer, the value of your gift can be increased
                        by 25% under the Gift Aid scheme at no extra cost to you.</p>
                    <p class="font-size-16 text-white">For example with Gift Aid, for every £1 you donate we'll receive
                        £1.25, and it doesn't cost you a penny.</p>
                </div>
                <br>
                <div class="bg pl-4 pr-4">
                    <label class="checkbox">
                        <input type="checkbox" name="gift_aid" value="1"><span><i class="fal fa-check"></i></span>
                        <b>Yes, I am a UK taxpayer and would like Islamic Help to treat all donations as Gift Aid
                            donations.</b>
                    </label>
                </div>
            </div>

            <div class="pt-5"></div>
            <div class="form-title"><b>PAYMENT</b></div>

            @if ($hasSingleDonations)
                <div class="mb-4 text-center">
                    <label class="radio mr-5">
                        <input type="radio" name="pay_method"
                               value="{{Setting::get(Setting::ENABLE_STRIPE)?'stripe':'global' }}" checked><span><i
                                class="fal fa-check"></i></span>
                        <b>PAY BY CARD</b>
                    </label>
                    <label class="radio">
                        <input type="radio" name="pay_method" value="paypal"><span><i class="fal fa-check"></i></span>
                        <b>PAY BY PAYPAL</b>
                    </label>
                </div>
            @if(Setting::get(Setting::ENABLE_STRIPE))
{{--                <div class="mb-4 text-center" style="display: none" id="stripe-checkbox">--}}
{{--                    <label class="checkbox">--}}
{{--                        <input type="checkbox" name="stripe_fee"><span><i--}}
{{--                                    class="fal fa-check"></i></span>--}}
{{--                        <b>I'm happy to cover the payment processing fees <b id="commission">{{ '(+£' . \App\Services\StripeService::countCommission(\App\Models\CartItem::getCartSum()) . ')' }}</b></b>--}}
{{--                    </label>--}}
{{--                </div>--}}
            @endif
            @endif

            @if ($hasMonthlyDonations && !Setting::get(Setting::ENABLE_STRIPE))
                <div class="row mb-3">
                    <div class="form-group col-12">
                        <label><b>Account Number*</b></label>
                        <input class="form-control" name="account_number" required placeholder="Enter Account Number">
                    </div>
                    <div class="form-group col-12">
                        <label><b>Sort Code*</b></label>
                        <input class="form-control" name="sort_code" required placeholder="Enter Sort Code">
                    </div>
                    <div class="form-group col-12">
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

        <button type="submit" id="cart-pay" class="btn btn-danger w-100">
            @if($hasMonthlyDonations && Setting::get(Setting::ENABLE_STRIPE))
                Set up your monthly payments
            @else
                Pay Now
            @endif
            <i class="moon-icons-arrow-right"></i></button>
        </form>

        <div class="pt-5"></div>
    </div>
    <script>
        $( document ).ready(function() {

            $('[name="pay_method"]').change(function() {
                if($('[name="pay_method"]:checked').val()  === 'stripe') {
                    $('#stripe-checkbox').show();
                    if($('#stripe-checkbox [name="stripe_fee"]').prop('checked')){
                        $('#stripe-fee').show();
                    } else {
                        $('#stripe-fee').hide();
                    }
                } else {
                    $('#stripe-checkbox').hide();
                    $('#stripe-fee').hide();
                }
            });

            $('#stripe-checkbox [name="stripe_fee"]').change(function() {
                if($('#stripe-checkbox [name="stripe_fee"]').prop('checked')){
                    $('#stripe-fee').show();
                } else {
                    $('#stripe-fee').hide();
                }
            });

            if($('[name="pay_method"]:checked').val()  === 'stripe') {
                $('#stripe-checkbox').show();
            }
            if($('#stripe-checkbox [name="stripe_fee"]').prop('checked')){
                $('#stripe-fee').show();
            }
        });


    </script>

    {!! NoCaptcha::renderJs() !!}
@endsection

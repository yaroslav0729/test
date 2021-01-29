@extends('layouts.main')

@section('header')
    @include('parts.header')
@endsection

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&libraries=places&language=EN"
            defer></script>
@endsection

@section('content')

    <div class="donated-page">
        <form action="{{ route('cart.order') }}" method="POST">
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
                    <input type="text" name="first_name"
                           class="form-control @error('first_name') border-danger @enderror"
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
                <div class="form-group">
                    <label><b>FIND MY ADDRESS</b></label>
                    <input type="text" id="autocomplete" name="post_code" class="form-control"
                           placeholder="Type postcode..." autocomplete="off">
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
                <div class="manual-address" style="@if ($errors->any()) display: block @else display: none @endif">
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
                        <input type="text" id="administrative_area_level_2" name="county"
                               class="form-control auto-address" value="{{ old('county') }}">
                    </div>
                    <div class="form-group">
                        <label><b>COUNTRY</b></label>
                        <select class="form-control" id="country" name="country">
                            @foreach (\App\Models\Country::getAllEnabled() as $country)
                                <option value="{{ $country->id }}"
                                        @if(old('country'))
                                            @if($country->id == old('country'))
                                            selected="selected"
                                            @endif
                                        @else
                                            @if($country->id == 187)
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

            <div class="form-title"><b>ADD A NOTE?</b></div>
            <div>
                <div class="form-group">
                    <label><b>NOTE</b> (ON BEHALF OF)</label>
                    <textarea name="notes" rows="1" class="form-control" value="{{ old('notes') }}"></textarea>
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
                        <input type="checkbox"><span><i class="fal fa-check"></i></span>
                        <b>Yes, I am a UK taxpayer and would like Islamic Help to treat all donations as Gift Aid
                            donations.</b>
                    </label>
                </div>
            </div>

            <div class="pt-5"></div>
            <div class="form-title"><b>PAYMENT</b></div>

            <div class="mb-4 text-center">
                <label class="radio mr-5">
                    <input type="radio" name="pay_method" value="paypal" checked><span><i
                            class="fal fa-check"></i></span>
                    <b>PAY BY CARD</b>
                </label>
                <label class="radio">
                    <input type="radio" name="pay_method" value="global"><span><i class="fal fa-check"></i></span>
                    <b>PAY BY PAL</b>
                </label>
            </div>

            <button type="submit" class="btn btn-danger w-100">Pay Now <i class="moon-icons-arrow-right"></i></button>
        </form>

        <div class="pt-5"></div>
    </div>

@endsection

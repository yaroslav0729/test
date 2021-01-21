@extends('layouts.main')

@section('header')
    @include('parts.header')
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
                    <label><b>FIRST NAME</b></label>
                    <input type="text" name="first_name" class="form-control">
                </div>
                <div class="form-group">
                    <label><b>LAST NAME</b></label>
                    <input type="text" name="last_name" class="form-control">
                </div>
                <div class="form-group">
                    <label><b>EMAIL</b></label>
                    <input type="text" name="email" class="form-control">
                </div>
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
                <input type="text" name="post_code" class="form-control" placeholder="Type postcode...">
            </div>
            <div class="text-right">
                <a href="#" class="toggle-manual-address font-size-12 text-dark"><b>OR ENTER MANUALLY</b> <i class="far fa-chevron-down"></i></a>
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
            <script>
                $(function () {
                    $('.toggle-manual-address').on('click', function (e) {
                        e.preventDefault();
                        $('.manual-address').toggle()
                    })
                });
            </script>
            <div class="manual-address" style="display: none">
                <div class="pt-3"></div>
                <div class="form-group">
                    <label><b>ADDRESS</b> (LINE 1)</label>
                    <input type="text" name="address_1" class="form-control">
                </div>
                <div class="form-group">
                    <label><b>ADDRESS</b> (LINE 2)</label>
                    <input type="text" name="address_2" class="form-control">
                </div>
                <div class="form-group">
                    <label><b>CITY</b></label>
                    <input type="text" name="city" class="form-control">
                </div>
                <div class="form-group">
                    <label><b>COUNTRY</b></label>
                    <select class="form-control" name="country">
                        @foreach (\App\Models\Country::getAllEnabled() as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>    
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="pt-5"></div>
        </div>

        <div class="form-title"><b>ADD A NOTE?</b></div>
        <div>
            <div class="form-group">
                <label><b>NOTE</b> (ON BEHALF OF)</label>
                <textarea name="notes" rows="1" class="form-control"></textarea>
            </div>
            <div class="pt-5"></div>
        </div>

        <div class="gift-aid-sheet">
            <div class="mb-4 text-right"><img src="/img/Gift-aid-logo-white.png" alt="" class="img-fluid"></div>
            <div class="pl-4 pr-4 mb-4">
                <p class="font-size-25 text-white"><b>Make your donation go 25% further, for free!</b></p>
                <p class="font-size-16 text-white">If you are a UK taxpayer, the value of your gift can be increased by 25% under the Gift Aid scheme at no extra cost to you.</p>
                <p class="font-size-16 text-white">For example with Gift Aid, for every £1 you donate we'll receive £1.25, and it doesn't cost you a penny.</p>
            </div>
            <br>
            <div class="bg pl-4 pr-4">
                <label class="checkbox">
                    <input type="checkbox"><span><i class="fal fa-check"></i></span>
                    <b>Yes, I am a UK taxpayer and would like Islamic Help to treat all donations  as Gift Aid donations.</b>
                </label>
            </div>
        </div>

        <div class="pt-5"></div>
        <div class="form-title"><b>PAYMENT</b></div>

        <div class="mb-4 text-center">
            <label class="radio mr-5">
                <input type="radio" name="pay_method" value="paypal" checked><span><i class="fal fa-check"></i></span>
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
@extends('layouts.main')

@section('header')
    @include('parts.header')
@endsection

@section('scripts')
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('googlemap.map_key') }}&libraries=places&language=EN"
        defer>
    </script>
    {!! NoCaptcha::renderJs() !!}
@endsection


@section('content')

    @php
    $cart = \App\Models\CartItem::getCart();
    $cartSum = \App\Models\CartItem::getCartSum();
    $hasSingleDonations = \App\Models\CartItem::hasSingleDonations();
    $hasMonthlyDonations = \App\Models\CartItem::hasMonthlyDonations();
    $showStartDateSelector = now()->isBefore(\Carbon\Carbon::createFromFormat('Y-m-d', '2024-03-11')->startOfDay());
    @endphp

    <div class="donated-page">
        <section class="box">
            <div class="wrap">
                <form id="ramadan-form" action="{{ route('nights-of-mercy.store') }}" method="POST">
                    @csrf
                    <p class="font-size-30 mb-5"><b>Your Nights of Mercy Donation</b></p>
                    <h5>Set up your automated donations here, it takes just a few minutes</h5>
                    <div class="text-right pb-3"><b>DONATION OPTIONS</b></div>
                    <div class="black-line"></div>
                    <div class="pt-5"></div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <p>
                                FIRSTLY, HOW MUCH WOULD YOU LIKE TO DONATE TO EACH CAUSE IN TOTAL
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="@error('first_name') text-danger @enderror"><b>Water</b></label>
                                <div class="form-group" currency="£">
                                    <input
                                        type="number"
                                        name="amount[water]"
                                        id="amount"
                                        class="form-control"
                                        placeholder="Enter Total Amount"
                                        oninput="this.value = Math.abs(this.value)"
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="@error('first_name') text-danger @enderror"><b>Education</b></label>
                                <div class="form-group" currency="£">
                                    <input
                                        type="number"
                                        name="amount[education]"
                                        id="amount"
                                        class="form-control"
                                        placeholder="Enter Total Amount"
                                        oninput="this.value = Math.abs(this.value)"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="@error('first_name') text-danger @enderror"><b>Umrah for Orphans</b></label>
                                <div class="form-group" currency="£">
                                    <input
                                        type="number"
                                        name="amount[umrah_for_orphans]"
                                        id="amount"
                                        class="form-control"
                                        placeholder="Enter Total Amount"
                                        oninput="this.value = Math.abs(this.value)"
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="@error('first_name') text-danger @enderror"><b>Zakat</b></label>
                                <div class="form-group" currency="£">
                                    <input
                                        type="number"
                                        name="amount[zakat]"
                                        id="amount"
                                        class="form-control"
                                        placeholder="Enter Total Amount"
                                        oninput="this.value = Math.abs(this.value)"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="@error('first_name') text-danger @enderror"><b>Food Packs</b></label>
                                <div class="form-group" currency="£">
                                    <input
                                        type="number"
                                        name="amount[food_packs]"
                                        id="amount"
                                        class="form-control"
                                        placeholder="Enter Total Amount"
                                        oninput="this.value = Math.abs(this.value)"
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="@error('first_name') text-danger @enderror"><b>Surgeons in Gaza</b></label>
                                <div class="form-group" currency="£">
                                    <input
                                        type="number"
                                        name="amount[surgeons_in_gaza]"
                                        id="amount"
                                        class="form-control"
                                        placeholder="Enter Total Amount"
                                        oninput="this.value = Math.abs(this.value)"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label id="total-amount" style="font-size: 1.2em;"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="start_date_container">
                        <div class="col-md-1"></div>
                        <div class="col-10">
                            <div class="form-group">
                                <label><b>When was the date of your first fast this Ramadan?</b></label>
                                <select class="form-control" required name="start_date" id="start_date">
                                    <option value="2024-03-11">11th of March</option>
                                    <option value="2024-03-12">12th of March</option>
                                </select>
                            </div>
                            <p class="text-danger ml-3 font-size-14" id="message-error-amount"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-10">
                            <div class="form-group">
                                <label><b>HOW OFTEN DO YOU WANT TO DONATE?</b></label>
                                <select class="form-control" required name="frequency" id="frequency">
                                    <option value="1">Each Day of Ramadan</option>
                                    <option value="2">The last ten nights</option>
                                    <option value="3">The last ten nights with more donated on odd nights</option>
                                </select>
                            </div>
                            <p class="text-danger ml-3 font-size-14" id="message-error-amount"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="row hidden-md-up" id="withdrawal-frequency-desktop">

                            </div>
                        </div>
                    </div>
                    <div class="text-right pb-3"><b>YOUR DETAILS</b></div>
                    <div class="black-line"></div>
                    <div class="pt-5"></div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <p>
                                And now for some quick details...
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label><b>TITLE</b> (OPTIONAL)</label>
                                <select class="form-control" required name="title">
                                    <option value="mr">Mr</option>
                                    <option value="mrs">Mrs</option>
                                    <option value="miss">Miss</option>
                                    <option value="ms">Ms</option>
                                    <option value="dr">Dr</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="@error('first_name') text-danger @enderror"><b>FIRST NAME</b></label>
                                <input type="text" name="first_name" required placeholder="Enter first name..."
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
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="@error('last_name') text-danger @enderror"><b>LAST NAME</b></label>
                                <input type="text" name="last_name" required placeholder="Enter last name..."
                                    class="form-control @error('last_name') border-danger @enderror"
                                    value="{{ old('last_name') }}">
                            </div>
                            @error('last_name')
                                <p class="text-danger ml-3 font-size-14">*{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="@error('email') text-danger @enderror"><b>EMAIL</b></label>
                                <input type="text" name="email" required placeholder="enter email"
                                    class="form-control @error('email') border-danger @enderror"
                                    value="{{ old('email') }}">
                            </div>
                            @error('email')
                                <p class="text-danger ml-3 font-size-14">*{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="pt-5"></div>

                    <div class="text-right pb-3"><b>ADDRESS & CONTACT</b></div>
                    <div class="black-line height-1"></div>
                    <div class="pt-5"></div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            <div class="form-group postcode-finder-container">
                                <label><b>ENTER YOUR POSTCODE</b></label>
                                <input type="text" id="postcode-finder" required class="form-control" name="some_adr"
                                    autocomplete="off" placeholder="Type postcode...">

                                <div id="postcode-results" class="postcode-results d-none">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label><b>CONTACT NUMBER</b> (OPTIONAL)</label>
                                <input type="text" placeholder="Enter the phone number..." name="phone"
                                    class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="manual-address" style="display: block">
                        <div class="pt-3"></div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="@error('address_1') text-danger @enderror"><b>ADDRESS</b> (LINE
                                        1)</label>
                                    <input type="text" id="route" required name="address_1" placeholder="Enter the address..."
                                        class="form-control auto-address @error('address_1') border-danger @enderror"
                                        value="{{ old('address_1') }}">
                                </div>
                                @error('address_1')
                                    <p class="text-danger ml-3 font-size-14">*{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label><b>ADDRESS</b> (LINE 2)</label>
                                    <input type="text" name="address_2" placeholder="Enter the address..."
                                        class="form-control auto-address" value="{{ old('address_2') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="@error('city') text-danger @enderror"><b>CITY</b></label>
                                    <input type="text" id="postal_town" required name="city" placeholder="Enter the city..."
                                        class="form-control auto-address @error('city') border-danger @enderror"
                                        value="{{ old('city') }}">
                                </div>
                                @error('city')
                                    <p class="text-danger ml-3 font-size-14">*{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label><b>COUNTY</b></label>
                                    <input type="text" id="administrative_area_level_2" class="form-control auto-address"
                                        name="county" value="{{ old('county') }}">
                                </div>
                            </div>
                        </div>
                        <div class="pt-3"></div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="@error('post_code') text-danger @enderror"><b>POST CODE</b></label>
                                    <input type="text" required id="postal_code"
                                        class="form-control auto-address @error('post_code') border-danger @enderror"
                                        name="post_code" placeholder="Enter postcode..." value="{{ old('post_code') }}">
                                </div>
                                @error('post_code')
                                    <p class="text-danger ml-3">*{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label><b>COUNTRY</b></label>
                                    <select class="form-control" id="country" required name="country">
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
{{--                    <div class="gift-aid-sheet">--}}
{{--                        <div class="pl-4 pr-4 mb-4">--}}
{{--                            <p class="font-size-20 text-white"><b>Make your donation go 25% further, for free!</b></p>--}}
{{--                            <p class="font-size-16 text-white">If you are a UK taxpayer, the value of your gift can be--}}
{{--                                increased by 25% under the Gift Aid scheme at no extra cost to you. For example with--}}
{{--                                Gift Aid, for every £1 you donate we'll receive £1.25, and it doesn't cost you a--}}
{{--                                penny.</p>--}}
{{--                        </div>--}}
{{--                        <br>--}}
{{--                        <div class="bg pl-4 pr-4">--}}
{{--                            <label class="checkbox">--}}
{{--                                <input type="checkbox" name="gift_aid" value="1"><span><i class="fal fa-check"></i></span>--}}
{{--                                <b>Yes, I am a UK taxpayer and would like Islamic Help to treat all donations I have--}}
{{--                                    made over the past four years and all donations I make in the future (unless I--}}
{{--                                    notify you otherwise) as Gift Aid donations.</b>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-12 d-flex justify-content-center mt-3">
                            <p id="summary-message"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-12 d-flex justify-content-center mt-3">
                            <button type="submit" id="ramadan-pay" class="btn btn-danger border-white">Automate My Donations</button>
                        </div>
                        <div class="col-md-12 d-flex justify-content-center mt-3 text-center">
                            <p>
                                One final step - we need your payment details.
                                Your bank may request approval via its app. A £0.00 charge might pop up—it's purely to schedule your future donations.
                                After clicking 'automate my donations', please don't close the window until you see the payment screen.
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <div id="ramadan-overlay">
        <div class="loading-container">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <p class="mt-3 mb-0">Please do not close this window</p>
        </div>
    </div>
    <style>
        #ramadan-overlay {
            position: fixed;
            flex-direction: column;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: none;
            justify-content: center;
            align-items: center;
            background: rgba(0, 0, 0, 0.4);
            color: whitesmoke;
        }

        #ramadan-overlay.active {
            display: flex;
        }

        .loading-container {
            background: white;
            border-radius: 4px;
            padding: 14px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: #101525;
        }
    </style>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" crossorigin="anonymous"></script>
    <script>
        let startDate = moment('2024-03-11');
        let endDate = moment('2024-04-10');

        const frequencyElement = document.getElementById('frequency');
        const nodeDesktop = document.getElementById('withdrawal-frequency-desktop');
        const nodeMobile = document.getElementById('withdrawal-frequency-mobile');
        const startDateSelector = document.getElementById('start_date');

        if (startDateSelector) {
            startDate = moment(startDateSelector.value);
            endDate = startDate.clone().add(29, 'days');
        }

       const paymentForm = document.getElementById("ramadan-form");

       paymentForm.addEventListener("submit", (e) => {
           e.preventDefault();

           const spinner = "<div class=\"spinner-border text-light\" role=\"status\">\n  <span class=\"sr-only\">Loading...</span>\n</div>";

           const button = document.getElementById('ramadan-pay');

           button.innerHTML = spinner;
           button.disabled = true;

           paymentForm.submit();
           $('#ramadan-overlay').addClass('active');
           $('body').css('overflow', 'hidden');
       })

        let getDaysBetweenDates = function(startDate, endDate) {
            let currentStartDate = startDate.clone();
            let dates = [];

            while (currentStartDate.startOf('day').isSameOrBefore(endDate.startOf('day'))) {
                dates.push(currentStartDate.format('MM-DD-YYYY'));
                currentStartDate.add(1, 'days');
            }

            return dates;
        };

        const getStartDate = function (startDate, endDate) {
            if ([2, 3].includes(parseInt(frequencyElement.value))) {
                const date = endDate.clone().subtract(9, 'days');
                return date.format('MM-DD-YYYY') > moment().format('MM-DD-YYYY')
                    ? date
                    : moment();
            }

            return startDate.format('MM-DD-YYYY') > moment().format('MM-DD-YYYY')
                ? startDate
                : moment();
        }

        const createItem = function (date, amount, numberDay) {
            const parentElement = document.createElement('div');
            parentElement.className = 'col-md-4';

            const card = document.createElement('div');
            card.className = 'card mb-4';
            card.style = 'background: #e3effe !important; border-radius: 5px; padding: 0.7em 0 0.7em 0'

            const cardBody = document.createElement('div');
            cardBody.className = 'card-block';

            const titleElement = document.createElement('p');
            titleElement.className = 'card-title text-center';
            titleElement.innerHTML = `${moment(date, 'MM-DD-YYYY').clone().format('MMMM D, YYYY')}`;

            const amountElement = document.createElement('p');
            amountElement.className = 'card-text text-muted text-center';
            if (moment(date, 'MM-DD-YYYY').clone().date() % 2 === 0 && parseInt(frequencyElement.value) === 3) {
                amountElement.innerHTML = `&#163; ${amount.oven}`;
            } else if(moment(date, 'MM-DD-YYYY').clone().date() % 2 > 0 && parseInt(frequencyElement.value) === 3) {
                amountElement.innerHTML = `&#163; ${amount.odd}`;
            }
            else {
                amountElement.innerHTML = `&#163; ${amount}`;
            }

            const numberDayElement = document.createElement('p')
            numberDayElement.className = 'card-subtitle text-center';
            numberDayElement.innerHTML = `${moment.localeData().ordinal(numberDay)} Night`;

            cardBody.appendChild(titleElement);
            cardBody.appendChild(amountElement);
            cardBody.appendChild(numberDayElement);
            card.appendChild(cardBody);

            parentElement.appendChild(card);

            nodeDesktop.appendChild(parentElement);
        }

        const calculateAmount = function (countDays, sum) {
            switch (parseInt(frequencyElement.value)) {
                case 1:
                case 2:
                    const amount = sum / countDays;
                    return parseFloat(amount).toFixed(2);
                case 3:
                    const oven = sum / (countDays * 1.5);
                    const odd = oven * 2;

                    return {
                        oven: parseFloat(oven).toFixed(2),
                        odd: parseFloat(odd).toFixed(2)
                    };
            }
        }

        const getSum = function () {
            const amounts = document.querySelectorAll('#amount');

            let sum = 0;

            for (const amount of amounts) {
                sum = sum + (amount.value === '' ? 0 : parseInt(amount.value));
            }

            return sum;
        }

        const showTotalAmount = (total) => {
            const element = document.getElementById('total-amount');
            element.innerHTML = `Total £${total}`;
        }

        const drawTableDonates = () => {
            const currentStartDate = getStartDate(startDate, endDate);
            const range = getDaysBetweenDates(currentStartDate, endDate);

            const countDay = range.length;
            const amount = calculateAmount(parseInt(countDay), getSum());

            while (nodeDesktop.firstChild) {
                nodeDesktop.removeChild(nodeDesktop.lastChild);
            }

            range.forEach(function (date, index) {
                createItem(date, amount, index + 1);
            })

            showTotalAmount(getSum());
        }

        const amounts = document.querySelectorAll('#amount');

        for (const amount of amounts) {
           amount.addEventListener('input', drawTableDonates);
        }

        frequencyElement.addEventListener('change', () => {
            drawTableDonates();
        });
        if (startDateSelector) {
            startDateSelector.addEventListener('change', (event) => {
                startDate = moment(event.target.value);
                endDate = moment(event.target.value).add(29, 'days');
                drawTableDonates();
            });
        }
    </script>
{{--    <script>--}}
{{--        var stripe = Stripe('{{ config('stripe.public_key') }}');--}}
{{--        var elements = stripe.elements();--}}
{{--        var style = {--}}
{{--            base: {--}}
{{--                color: "#32325d",--}}
{{--            }--}}
{{--        };--}}


{{--        var card = elements.create("card", { style: style });--}}
{{--        card.mount("#card-element");--}}

{{--        let cardErrors = false;--}}

{{--        card.on('change', function(event) {--}}
{{--            var displayError = document.getElementById('card-errors');--}}
{{--            if (event.error) {--}}
{{--                displayError.textContent = event.error.message;--}}
{{--                cardErrors = true;--}}
{{--            } else {--}}
{{--                displayError.textContent = '';--}}
{{--                cardErrors = false;--}}
{{--                createPaymentMethod()--}}
{{--            }--}}
{{--        });--}}

{{--        let paymentForm = document.getElementById("ramadan-form");--}}

{{--        paymentForm.addEventListener("submit", (e) => {--}}
{{--            e.preventDefault();--}}

{{--            if (cardErrors !== false) {--}}
{{--                return false;--}}
{{--            }--}}

{{--            var spinner = "<div class=\"spinner-border text-light\" role=\"status\">\n  <span class=\"sr-only\">Loading...</span>\n</div>";--}}

{{--            let button = document.getElementById('ramadan-pay');--}}

{{--            button.innerHTML = spinner;--}}
{{--            button.disabled = true;--}}

{{--            paymentForm.submit()--}}
{{--        });--}}

{{--        function createPaymentMethod()--}}
{{--        {--}}
{{--            stripe.createPaymentMethod({--}}
{{--                type: 'card',--}}
{{--                card: card,--}}
{{--                billing_details: {--}}
{{--                    name: $('input[name=first_name]').val() + ' ' + $('input[name=last_name]').val(),--}}
{{--                    email: $('input[name=email]').val(),--}}
{{--                    phone: $('input[name=phone]').val(),--}}
{{--                    address: {--}}
{{--                        city: $('input[name=city]').val(),--}}
{{--                        line1: $('input[name=address_1]').val(),--}}
{{--                        line2: $('input[name=address_2]').val(),--}}
{{--                        postal_code: $('input[name=post_code]').val(),--}}
{{--                    }--}}
{{--                },--}}
{{--            }).then(function(result) {--}}
{{--                let newField = document.createElement('input');--}}
{{--                newField.setAttribute('type','hidden');--}}
{{--                newField.setAttribute('name','payment_method');--}}
{{--                newField.setAttribute('value',result.paymentMethod.id);--}}

{{--                paymentForm.appendChild(newField);--}}
{{--            });--}}
{{--        }--}}
{{--    </script>--}}
{{--    <script>--}}
{{--        var stripe = Stripe('{{ config('stripe.public_key') }}');--}}
{{--        var elements = stripe.elements();--}}
{{--        var form = document.getElementById('ramadan-form');--}}
{{--        var submitButton = document.getElementById('ramadan-pay');--}}
{{--        var card = elements.create('card');--}}
{{--        card.mount('#card-element');--}}

{{--        form.addEventListener('submit', function(event) {--}}
{{--            event.preventDefault();--}}
{{--            submitButton.disabled = true;--}}
{{--            stripe.createPaymentMethod('card', card).then(function(result) {--}}
{{--                if (result.error) {--}}
{{--                    // Handle errors--}}
{{--                    var errorElement = document.getElementById('card-errors');--}}
{{--                    errorElement.textContent = result.error.message;--}}
{{--                    submitButton.disabled = false;--}}
{{--                } else {--}}
{{--                    // Get the Stripe payment method ID and token--}}
{{--                    var paymentMethod = result.paymentMethod;--}}
{{--                    var token = result.token;--}}

{{--                    // Add the payment method ID to the checkout form--}}
{{--                    var hiddenInput = document.createElement('input');--}}
{{--                    hiddenInput.setAttribute('type', 'hidden');--}}
{{--                    hiddenInput.setAttribute('name', 'stripe_payment_method');--}}
{{--                    hiddenInput.setAttribute('value', paymentMethod.id);--}}
{{--                    form.appendChild(hiddenInput);--}}

{{--                    // Submit the checkout form with the Stripe token--}}
{{--                    stripe.confirmCardPayment("{{ $client_secret }}", {--}}
{{--                        payment_method: {--}}
{{--                            card: card,--}}
{{--                            billing_details: {--}}
{{--                                name: 'Vivien Shepherd',--}}
{{--                                email: 'qufefovam@mailinator.com',--}}
{{--                            },--}}
{{--                        }--}}
{{--                    }).then(function(result) {--}}
{{--                        if (result.error) {--}}
{{--                            // Handle errors--}}
{{--                            var errorElement = document.getElementById('card-errors');--}}
{{--                            errorElement.textContent = result.error.message;--}}
{{--                            submitButton.disabled = false;--}}
{{--                        } else {--}}
{{--                            // Submit the checkout form with the Stripe token--}}
{{--                            // var form = document.getElementById('payment-form');--}}
{{--                            // var hiddenInput = document.createElement('input');--}}
{{--                            // hiddenInput.setAttribute('type', 'hidden');--}}
{{--                            // hiddenInput.setAttribute('name', 'stripe_token');--}}
{{--                            // hiddenInput.setAttribute('value', token.id);--}}
{{--                            // form.appendChild(hiddenInput);--}}
{{--                            form.submit();--}}
{{--                        }--}}
{{--                    });--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}

@endsection

$(function() {
    const spinner = `<div class="spinner-border text-light" role="status">
  <span class="sr-only">Loading...</span>
</div>`;
    let payText = "Pay Now";
    const stringCounter = document.querySelector(".string-counter");
    const notesInput = document.querySelector('[name="notes"]');
    const mainForm = document.querySelector("#payment-form");
    const cartPayButton = document.querySelector("#cart-pay");
    const buttonText = document.getElementById('button-text');
    const spinnerElement = document.getElementById('spinner');

    // Initialize Stripe if enabled
    let stripe = null;
    let card = null;
    let paymentRequest = null;

    if (typeof window.stripe_enabled !== 'undefined' && window.stripe_enabled) {
        stripe = Stripe(window.stripe_public_key);
        const elements = stripe.elements({
            locale: 'en-GB'
        });

        const style = {
            base: {
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        // Create individual field elements for better control over UK postal code
        const cardNumber = elements.create('cardNumber', {style: style});
        const cardExpiry = elements.create('cardExpiry', {style: style});
        const cardCvc = elements.create('cardCvc', {style: style});
        const postalCode = elements.create('postalCode', {
            style: style,
            placeholder: 'Postal Code' // Explicitly set UK placeholder
        });

        // Mount individual elements
        cardNumber.mount('#card-number-element');
        cardExpiry.mount('#card-expiry-element');
        cardCvc.mount('#card-cvc-element');
        postalCode.mount('#postal-code-element');

        // Store references for later use
        card = {
            cardNumber: cardNumber,
            cardExpiry: cardExpiry,
            cardCvc: cardCvc,
            postalCode: postalCode
        };

        // Add error handling for all elements
        [cardNumber, cardExpiry, cardCvc, postalCode].forEach(element => {
            element.on('change', function(event) {
                const displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });
        });

        // Initialize Payment Request for Google Pay / Apple Pay
        initializePaymentRequest(elements);

        // Initialize Google Pay specifically for Chrome on iOS
        initializeGooglePay();
    }

    function initializePaymentRequest(elements) {
        // Get cart total from the page
        let cartSum = 0;
        const pageSumElement = document.getElementById('page-sum') ||
                              document.querySelector('.cart-total') ||
                              document.querySelector('[data-cart-sum]');

        if (pageSumElement) {
            const sumText = pageSumElement.innerText || pageSumElement.textContent || '';
            cartSum = parseFloat(sumText.replace(/[^0-9.-]+/g,"")) || 0;
        }

        // Fallback: try to get from cart items
        if (cartSum <= 0) {
            const cartItems = document.querySelectorAll('.cart-item-amount, [data-amount]');
            cartItems.forEach(item => {
                const amount = parseFloat((item.innerText || item.dataset.amount || '').replace(/[^0-9.-]+/g,"")) || 0;
                cartSum += amount;
            });
        }

        // Additional fallback: search for any amount on the page
        if (cartSum <= 0) {
            const totalElements = document.querySelectorAll('*');
            for (let element of totalElements) {
                const text = element.innerText || element.textContent || '';
                const match = text.match(/£\s*(\d+(?:\.\d{2})?)/);
                if (match) {
                    const amount = parseFloat(match[1]);
                    if (amount > 0 && amount < 10000) {
                        cartSum = amount;
                        break;
                    }
                }
            }
        }

        if (cartSum <= 0) {
            return;
        }

        paymentRequest = stripe.paymentRequest({
            country: 'GB',
            currency: 'gbp',
            total: {
                label: 'Islamic Help Donation',
                amount: Math.round(cartSum * 100),
            },
            requestPayerName: true,
            requestPayerEmail: true,
            disableWallets: ['link']
        });

        const prButton = elements.create('paymentRequestButton', {
            paymentRequest: paymentRequest,
            style: {
                paymentRequestButton: {
                    type: 'donate',
                    theme: 'dark',
                    height: '48px',
                },
            },
        });

        paymentRequest.canMakePayment().then(function(result) {
            if (result) {
                const paymentRequestContainer = document.getElementById('payment-request-button');
                const paymentRequestDivider = document.getElementById('payment-request-divider');

                if (paymentRequestContainer) {
                    prButton.mount('#payment-request-button');
                    paymentRequestContainer.style.display = 'block';
                    if (paymentRequestDivider) {
                        paymentRequestDivider.style.display = 'block';
                    }
                }
            }
        });

        // Handle payment method creation from Payment Request
        paymentRequest.on('paymentmethod', function(ev) {
            // Validate required fields before processing payment
            if (!validateRequiredFields()) {
                ev.complete('fail');
                return;
            }

            // Add payment method ID to form
            const existingPaymentMethodInput = mainForm.querySelector('[name="payment_method_id"]');
            if (existingPaymentMethodInput) {
                existingPaymentMethodInput.remove();
            }

            const paymentMethodInput = document.createElement('input');
            paymentMethodInput.type = 'hidden';
            paymentMethodInput.name = 'payment_method_id';
            paymentMethodInput.value = ev.paymentMethod.id;
            mainForm.appendChild(paymentMethodInput);

            // Set payment method to indicate this came from Payment Request
            const existingPayMethodInput = mainForm.querySelector('[name="pay_method"]');
            if (!existingPayMethodInput) {
                const paymentMethodTypeInput = document.createElement('input');
                paymentMethodTypeInput.type = 'hidden';
                paymentMethodTypeInput.name = 'pay_method';
                paymentMethodTypeInput.value = 'payment_request';
                mainForm.appendChild(paymentMethodTypeInput);
            } else {
                existingPayMethodInput.value = 'payment_request';
            }

            // Complete the payment request
            ev.complete('success');

            // Submit the form
            setTimeout(() => {
                mainForm.submit();
            }, 100);
        });

        paymentRequest.on('cancel', function() {
            // Payment cancelled by user
        });
    }

    function validateRequiredFields() {
        const requiredFields = [
            { name: 'first_name', label: 'First Name' },
            { name: 'last_name', label: 'Last Name' },
            { name: 'email', label: 'Email' },
            { name: 'address_1', label: 'Address' },
            { name: 'city', label: 'City' },
            { name: 'post_code', label: 'Post Code' }
        ];

        for (let field of requiredFields) {
            const input = document.querySelector(`[name="${field.name}"]`);
            if (!input || !input.value.trim()) {
                alert(`Please fill in the ${field.label} field before proceeding with payment.`);
                return false;
            }
        }

        // Validate donation notes if required
        const donationNotes = document.querySelectorAll('[name^="notes_"]');
        for (let note of donationNotes) {
            if (note.hasAttribute('required') && !note.value.trim()) {
                alert('Please fill in all required donation notes before proceeding with payment.');
                return false;
            }
        }

        return true;
    }

    // Card number formatting (for non-Stripe fallback)
    function formatCardNumber(input) {
        let value = input.value.replace(/\D/g, '');
        let formattedValue = '';
        for (let i = 0; i < value.length; i++) {
            if (i > 0 && i % 4 === 0) {
                formattedValue += ' ';
            }
            formattedValue += value[i];
        }
        input.value = formattedValue;
    }

    // Expiry date formatting (for non-Stripe fallback)
    function formatExpiryDate(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length === 1 && Number(value) > 2) value = "0" + value;
        if (value.length === 2 && Number(value) > 12) value = "0" + value;
        if (value.length > 2) {
            value = value.substring(0, 2) + ' / ' + value.substring(2, 4);
        }
        input.value = value;
    }

    // CVV formatting (for non-Stripe fallback)
    function formatCVV(input) {
        let value = input.value.replace(/\D/g, '');
        input.value = value.substring(0, 3);
    }

    // Add input event listeners for formatting (non-Stripe fallback)
    $('[name="card_number"]').on('input', function() {
        formatCardNumber(this);
    });

    $('[name="expiry_date"]').on('input', function() {
        formatExpiryDate(this);
    });

    $('[name="cvv"]').on('input', function() {
        formatCVV(this);
    });

    $(document).on("change", '[name="pay_method"]', function() {
        const paymentMethod = this.value;
        const cardContainer = $('#card-payment-container');

        if (paymentMethod === 'paypal') {
            cardContainer.hide();
        } else {
            cardContainer.show();
        }

        // Also handle stripe-specific elements if they exist
        const stripeCheckbox = $('#stripe-checkbox');
        const stripeFee = $('#stripe-fee');

        if (paymentMethod === 'stripe') {
            stripeCheckbox.show();
            if (stripeCheckbox.find('[name="stripe_fee"]').prop('checked')) {
                stripeFee.show();
            } else {
                stripeFee.hide();
            }
        } else {
            stripeCheckbox.hide();
            stripeFee.hide();
        }
    });

    // Initialize card payment container visibility on page load
    $(document).ready(function() {
        const selectedPayMethod = $('[name="pay_method"]:checked').val();
        const cardContainer = $('#card-payment-container');

        if (selectedPayMethod === 'paypal') {
            cardContainer.hide();
        } else {
            cardContainer.show();
        }

        // Initialize stripe-specific elements
        const stripeCheckbox = $('#stripe-checkbox');
        const stripeFee = $('#stripe-fee');

        if (selectedPayMethod === 'stripe') {
            stripeCheckbox.show();
            if (stripeCheckbox.find('[name="stripe_fee"]').prop('checked')) {
                stripeFee.show();
            }
        } else {
            stripeCheckbox.hide();
            stripeFee.hide();
        }
    });

    // Handle stripe fee checkbox changes
    $(document).on('change', '#stripe-checkbox [name="stripe_fee"]', function() {
        const stripeFee = $('#stripe-fee');
        if ($(this).prop('checked')) {
            stripeFee.show();
        } else {
            stripeFee.hide();
        }
    });

    mainForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const paymentMethod = document.querySelector('[name="pay_method"]:checked')?.value;

        // Validate required fields first
        if (!validateRequiredFields()) {
            return;
        }

        // Validate payment method specific fields
        if (paymentMethod !== 'paypal') {
            if (stripe && card) {
                // Check if we have individual elements or combined card element
                if (card.cardNumber) {
                    // Individual elements - check each one
                    const cardElements = [card.cardNumber, card.cardExpiry, card.cardCvc, card.postalCode];
                    let hasEmptyElement = false;

                    cardElements.forEach(element => {
                        const elementContainer = element._element;
                        if (elementContainer && elementContainer.classList.contains('StripeElement--empty')) {
                            hasEmptyElement = true;
                        }
                    });

                    if (hasEmptyElement) {
                        const errorElement = document.getElementById('card-errors');
                        errorElement.textContent = 'Please complete all card details';
                        return;
                    }
                } else {
                    // Combined card element
                    const cardElement = document.getElementById('card-element');
                    if (!cardElement || cardElement.classList.contains('StripeElement--empty')) {
                        const errorElement = document.getElementById('card-errors');
                        errorElement.textContent = 'Please enter your card details';
                        return;
                    }
                }
            } else {
                // Fallback validation
                const cardNumber = document.querySelector('[name="card_number"]');
                const expiryDate = document.querySelector('[name="expiry_date"]');
                const cvv = document.querySelector('[name="cvv"]');

                if (cardNumber && (!cardNumber.value || cardNumber.value.replace(/\s/g, '').length !== 16)) {
                    alert('Please enter a valid 16-digit card number');
                    return;
                }

                if (expiryDate && (!expiryDate.value || !/^\d{2}\s*\/\s*\d{2}$/.test(expiryDate.value))) {
                    alert('Please enter a valid expiry date (MM/YY)');
                    return;
                }

                if (cvv && (!cvv.value || cvv.value.length !== 3)) {
                    alert('Please enter a valid 3-digit CVV');
                    return;
                }
            }
        }

        cartPayButton.disabled = true;
        buttonText.classList.add('d-none');
        spinnerElement.classList.remove('d-none');

        // Check bank account for monthly donations (mobile specific)
        if (document.querySelector('[name="account_number"]') && document.querySelector('[name="account_number"]').value) {
            let accountNumber = document.querySelector('[name="account_number"]').value;
            let sortCode = document.querySelector('[name="sort_code"]').value;
            let data = {
                _token: document.querySelector('[name="_token"]').value,
                account_number: accountNumber,
                sort_code: sortCode
            };
            $.ajax({
                url: "/cart/check-account",
                method: "post",
                data: data,
                success: response => {
                    if (response.success) {
                        mainForm.submit();
                    } else {
                        alert(response.error);
                        cartPayButton.disabled = false;
                        if(buttonText) buttonText.classList.remove('d-none');
                        if(spinnerElement) spinnerElement.classList.add('d-none');
                    }
                },
                error: () => {
                    alert('An error occurred while checking your bank account. Please try again.');
                    cartPayButton.disabled = false;
                    if(buttonText) buttonText.classList.remove('d-none');
                    if(spinnerElement) spinnerElement.classList.add('d-none');
                }
            });
            return;
        }

        if (paymentMethod === 'paypal') {
            mainForm.submit();
        } else if (stripe && card) {
            handleStripePayment();
        } else {
            handleFallbackPayment();
        }
    });

    function handleStripePayment() {
        // Check if we have individual elements or combined card element
        const cardElement = card.cardNumber ? card.cardNumber : card;

        stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
            billing_details: {
                name: document.querySelector('[name="first_name"]').value + ' ' + document.querySelector('[name="last_name"]').value,
                email: document.querySelector('[name="email"]').value,
                address: {
                    line1: document.querySelector('[name="address_1"]').value,
                    line2: document.querySelector('[name="address_2"]').value,
                    city: document.querySelector('[name="city"]').value,
                    postal_code: document.querySelector('[name="post_code"]').value,
                    country: 'GB'
                }
            }
        }).then(function(result) {
            if (result.error) {
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;

                cartPayButton.disabled = false;
                buttonText.classList.remove('d-none');
                spinnerElement.classList.add('d-none');
            } else {
                const paymentMethodInput = document.createElement('input');
                paymentMethodInput.type = 'hidden';
                paymentMethodInput.name = 'payment_method_id';
                paymentMethodInput.value = result.paymentMethod.id;
                mainForm.appendChild(paymentMethodInput);
                mainForm.submit();
            }
        });
    }

    function handleFallbackPayment() {
        const cardNumber = $('[name="card_number"]').val().replace(/\s/g, '');
        const expiryDate = $('[name="expiry_date"]').val().replace(/\s/g, '');
        const cvv = $('[name="cvv"]').val();

        // Validate card number (16 digits)
        if (cardNumber.length !== 16) {
            alert('Please enter a valid 16-digit card number');
            cartPayButton.disabled = false;
            buttonText.classList.remove('d-none');
            spinnerElement.classList.add('d-none');
            return;
        }

        // Validate expiry date (MM/YY format)
        if (!/^\d{2}\/\d{2}$/.test(expiryDate)) {
            alert('Please enter a valid expiry date (MM/YY)');
            cartPayButton.disabled = false;
            buttonText.classList.remove('d-none');
            spinnerElement.classList.add('d-none');
            return;
        }

        // Validate CVV (3 digits)
        if (cvv.length !== 3) {
            alert('Please enter a valid 3-digit CVV');
            cartPayButton.disabled = false;
            buttonText.classList.remove('d-none');
            spinnerElement.classList.add('d-none');
            return;
        }

        // Add card details to the main form
        const mainForm = document.querySelector("#payment-form");
        const cardNumberInput = document.createElement('input');
        cardNumberInput.type = 'hidden';
        cardNumberInput.name = 'card_number';
        cardNumberInput.value = cardNumber;
        mainForm.appendChild(cardNumberInput);

        const expiryDateInput = document.createElement('input');
        expiryDateInput.type = 'hidden';
        expiryDateInput.name = 'expiry_date';
        expiryDateInput.value = expiryDate;
        mainForm.appendChild(expiryDateInput);

        const cvvInput = document.createElement('input');
        cvvInput.type = 'hidden';
        cvvInput.name = 'cvv';
        cvvInput.value = cvv;
        mainForm.appendChild(cvvInput);

        mainForm.submit();
    }

    function initializeGooglePay() {
        // Only display Google Pay on Chrome running on iOS devices
        const isIphoneChrome = /CriOS/i.test(navigator.userAgent) && /iphone|ipod|ipad/i.test(navigator.userAgent);
        if (!isIphoneChrome) {
            return;
        }

        // Helper to calculate cart total (duplicate of logic in initializePaymentRequest)
        function calculateCartSum() {
            let total = 0;
            const pageSumElement = document.getElementById('page-sum') ||
                                    document.querySelector('.cart-total') ||
                                    document.querySelector('[data-cart-sum]');
            if (pageSumElement) {
                const sumText = pageSumElement.innerText || pageSumElement.textContent || '';
                total = parseFloat(sumText.replace(/[^0-9.-]+/g, "")) || 0;
            }
            if (total <= 0) {
                const cartItems = document.querySelectorAll('.cart-item-amount, [data-amount]');
                cartItems.forEach(item => {
                    const amount = parseFloat((item.innerText || item.dataset.amount || '').replace(/[^0-9.-]+/g, "")) || 0;
                    total += amount;
                });
            }
            return total;
        }

        const cartSum = calculateCartSum();
        if (cartSum <= 0) {
            return;
        }

        // Load Google Pay JS if not already present
        const loadGPayScript = (callback) => {
            if (window.google && window.google.payments && window.google.payments.api) {
                callback();
                return;
            }
            const existing = document.getElementById('google-pay-js');
            if (existing) {
                existing.addEventListener('load', callback);
                return;
            }
            const script = document.createElement('script');
            script.id = 'google-pay-js';
            script.src = 'https://pay.google.com/gp/p/js/pay.js';
            script.onload = callback;
            document.head.appendChild(script);
        };

        loadGPayScript(() => {
            const paymentsClient = new google.payments.api.PaymentsClient({ environment: 'TEST' }); // change to 'PRODUCTION' when live

            const onGooglePayButtonClicked = () => {
                const paymentDataRequest = {
                    apiVersion: 2,
                    apiVersionMinor: 0,
                    allowedPaymentMethods: [{
                        type: 'CARD',
                        parameters: {
                            allowedAuthMethods: ['PAN_ONLY', 'CRYPTOGRAM_3DS'],
                            allowedCardNetworks: ['AMEX', 'DISCOVER', 'INTERAC', 'JCB', 'MASTERCARD', 'VISA']
                        },
                        tokenizationSpecification: {
                            type: 'PAYMENT_GATEWAY',
                            parameters: {
                                gateway: 'stripe',
                                'stripe:version': '2020-08-27',
                                'stripe:publishableKey': window.stripe_public_key
                            }
                        }
                    }],
                    merchantInfo: {
                        merchantName: 'Islamic Help'
                    },
                    transactionInfo: {
                        totalPriceStatus: 'FINAL',
                        totalPrice: cartSum.toFixed(2),
                        currencyCode: 'GBP'
                    }
                };

                paymentsClient.loadPaymentData(paymentDataRequest).then(function (paymentData) {
                    const paymentToken = JSON.parse(paymentData.paymentMethodData.tokenizationData.token);
                    const paymentMethodId = paymentToken.id;

                    // Remove existing hidden inputs if present
                    const existingPaymentMethodInput = mainForm.querySelector('[name="payment_method_id"]');
                    if (existingPaymentMethodInput) {
                        existingPaymentMethodInput.remove();
                    }

                    const paymentMethodInput = document.createElement('input');
                    paymentMethodInput.type = 'hidden';
                    paymentMethodInput.name = 'payment_method_id';
                    paymentMethodInput.value = paymentMethodId;
                    mainForm.appendChild(paymentMethodInput);

                    // Indicate google_pay as the payment method
                    const existingPayMethodInput = mainForm.querySelector('[name="pay_method"]');
                    if (!existingPayMethodInput) {
                        const paymentMethodTypeInput = document.createElement('input');
                        paymentMethodTypeInput.type = 'hidden';
                        paymentMethodTypeInput.name = 'pay_method';
                        paymentMethodTypeInput.value = 'payment_request';
                        mainForm.appendChild(paymentMethodTypeInput);
                    } else {
                        existingPayMethodInput.value = 'payment_request';
                    }

                    mainForm.submit();
                }).catch(function (err) {
                    console.error('Google Pay error:', err);
                });
            };

            // Create and mount the Google Pay button
            const button = paymentsClient.createButton({ onClick: onGooglePayButtonClicked, buttonColor: 'black', buttonType: 'long', buttonSizeMode: 'fill' });
            const gpayContainer = document.getElementById('google-pay-button');
            if (gpayContainer) {
                gpayContainer.innerHTML = '';
                gpayContainer.appendChild(button);
                gpayContainer.style.display = 'block';

                // Ensure the divider is visible too
                const divider = document.getElementById('payment-request-divider');
                if (divider) {
                    divider.style.display = 'block';
                }
            }
        });
    }

    if (stringCounter && notesInput) {
        stringCounter.innerText = `${notesInput.value.length}/${notesInput.maxLength}`;
        notesInput.addEventListener("input", e => {
            const maxLength = +e.target.maxLength;
            stringCounter.innerText = `${e.target.value.length}/${maxLength}`;
        });
    }
});

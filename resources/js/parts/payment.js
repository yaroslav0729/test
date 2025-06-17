$(function() {
    const stringCounter = document.querySelector(".string-counter");
    const notesInput = document.querySelector('[name="notes"]');
    const mainForm = document.querySelector("#payment-form");
    const cartPayButton = document.querySelector("#cart-pay");
    const buttonText = document.getElementById('button-text');
    const spinnerElement = document.getElementById('spinner');

    // Initialize Stripe if enabled
    let stripe = null;
    let card = null;
    let paymentElement = null;
    let expressCheckout = null;
    let elements = null;

    if (typeof window.stripe_enabled !== 'undefined' && window.stripe_enabled) {
        stripe = Stripe(window.stripe_public_key);
        elements = stripe.elements();

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

        card = elements.create('card', {style: style});
        card.mount('#card-element');

        card.on('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Initialize Express Checkout (Apple Pay / Google Pay)
        initializeExpressCheckout();
    } else {
        console.log('Stripe not enabled or not properly configured');
    }

    function initializeExpressCheckout() {
        const expressCheckoutContainer = document.getElementById('express-checkout');
        if (!expressCheckoutContainer) return;

        try {
            // Use mobile cart sum if available, otherwise get from page-sum element
            let cartSum = 0;
            if (typeof window.cartSum !== 'undefined') {
                cartSum = window.cartSum;
            } else {
                const pageSumElement = document.getElementById('page-sum');
                cartSum = pageSumElement ? parseFloat(pageSumElement.textContent) || 0 : 0;
            }

            const amount = Math.round(cartSum * 100); // Convert to cents

            // Check if amount is valid
            if (amount <= 0) {
                return;
            }

            const expressElements = stripe.elements({
                mode: 'payment',
                amount: amount,
                currency: 'gbp',
            });

            expressCheckout = expressElements.create('expressCheckout');
            expressCheckout.mount('#express-checkout');

            // Add a fallback message if express checkout is not available
            expressCheckout.on('ready', () => {
                // Express checkout is ready
            });

            expressCheckout.on('unavailable', () => {
                expressCheckoutContainer.innerHTML = '<p class="text-muted">Apple Pay / Google Pay not available on this device</p>';
            });

            expressCheckout.on('confirm', async (event) => {
                const billingDetails = event.billingDetails;

                const billingData = {
                    first_name: (billingDetails.name ? billingDetails.name.split(' ')[0] : '') || document.querySelector('[name="first_name"]').value || '',
                    last_name: (billingDetails.name ? billingDetails.name.split(' ').slice(1).join(' ') : '') || document.querySelector('[name="last_name"]').value || '',
                    email: billingDetails.email || document.querySelector('[name="email"]').value || '',
                    phone: billingDetails.phone || document.querySelector('[name="phone"]').value || '',
                    country: (billingDetails.address ? billingDetails.address.country : '') || document.querySelector('[name="country"]').value || 'GB',
                    city: (billingDetails.address ? billingDetails.address.city : '') || document.querySelector('[name="city"]').value || '',
                    post_code: (billingDetails.address ? billingDetails.address.postal_code : '') || document.querySelector('[name="post_code"]').value || '',
                    address: (billingDetails.address ? billingDetails.address.line1 : '') || document.querySelector('[name="address_1"]').value || '',
                };

                try {
                    // Submit elements to prepare for payment
                    const {error: submitError} = await expressElements.submit();
                    if (submitError) {
                        console.error('Submit error:', submitError);
                        return;
                    }

                    // Create order via API
                    const response = await fetch('/api/orders/express', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value,
                        },
                        body: JSON.stringify(billingData),
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.error || 'Failed to create order');
                    }

                    // Confirm payment with Stripe
                    const {error} = await stripe.confirmPayment({
                        elements: expressElements,
                        clientSecret: data.client_secret,
                        confirmParams: {
                            return_url: window.location.origin + '/thank-you?order=' + data.order.order_id,
                        },
                    });

                    if (error) {
                        console.error('Payment confirmation error:', error);
                    }
                } catch (error) {
                    console.error('Express checkout error:', error);
                    alert('Payment failed: ' + error.message);
                }
            });

        } catch (error) {
            console.error('Express checkout initialization error:', error);
            // Check if express checkout is supported
            if (error.message && error.message.includes('expressCheckout')) {
                console.log('Express checkout not supported on this device/browser');
            }
        }
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
        if (this.value === 'paypal') {
            $('#card-payment-container').hide();
        } else {
            $('#card-payment-container').show();
        }
    });

    mainForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const paymentMethod = document.querySelector('[name="pay_method"]:checked').value;

        cartPayButton.disabled = true;
        buttonText.classList.add('d-none');
        spinnerElement.classList.remove('d-none');

        if (paymentMethod === 'paypal') {
            mainForm.submit();
        } else if (stripe && card) {
            handleStripePayment();
        } else {
            handleFallbackPayment();
        }
    });

    function handleStripePayment() {
        stripe.createPaymentMethod({
            type: 'card',
            card: card,
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
            return;
        }

        // Validate expiry date (MM/YY format)
        if (!/^\d{2}\/\d{2}$/.test(expiryDate)) {
            alert('Please enter a valid expiry date (MM/YY)');
            return;
        }

        // Validate CVV (3 digits)
        if (cvv.length !== 3) {
            alert('Please enter a valid 3-digit CVV');
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

    if (stringCounter && notesInput) {
        stringCounter.innerText = `${notesInput.value.length}/${notesInput.maxLength}`;
        notesInput.addEventListener("input", e => {
            const maxLength = +e.target.maxLength;
            stringCounter.innerText = `${e.target.value.length}/${maxLength}`;
        });
    }
});

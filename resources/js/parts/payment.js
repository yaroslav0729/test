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

    if (typeof window.stripe_enabled !== 'undefined' && window.stripe_enabled) {
        stripe = Stripe(window.stripe_public_key);
        const elements = stripe.elements();

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
                cardValid = false;
            } else {
                displayError.textContent = '';
                cardValid = event.complete;
            }
        });
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

        const paymentMethod = document.querySelector('[name="pay_method"]:checked')?.value;

        // Validate payment method specific fields
        if (paymentMethod !== 'paypal') {
            if (stripe && card) {
                const cardElement = document.getElementById('card-element');
                if (!cardElement || cardElement.classList.contains('StripeElement--empty')) {
                    const errorElement = document.getElementById('card-errors');
                    errorElement.textContent = 'Please enter your card details';
                    return;
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

    if (stringCounter && notesInput) {
        stringCounter.innerText = `${notesInput.value.length}/${notesInput.maxLength}`;
        notesInput.addEventListener("input", e => {
            const maxLength = +e.target.maxLength;
            stringCounter.innerText = `${e.target.value.length}/${maxLength}`;
        });
    }
});

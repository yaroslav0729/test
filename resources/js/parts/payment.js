$(function() {
    const spinner = `<div class="spinner-border text-light" role="status">
  <span class="sr-only">Loading...</span>
</div>`;
    let payText = "";
    const stringCounter = document.querySelector(".string-counter");
    const notesInput = document.querySelector('[name="notes"]');

    // Initialize Stripe if enabled
    let stripe = null;
    let card = null;

    if (typeof window.stripe_enabled !== 'undefined' && window.stripe_enabled) {
        stripe = Stripe(window.stripe_public_key);
        const elements = stripe.elements();
        
        // Custom styling can be passed to options when creating an Element.
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

        // Create an instance of the card Element.
        card = elements.create('card', {style: style});
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
        $("#payment-card").toggleClass("d-none");
    });

    $("#cart-pay").on("click", function(e) {
        e.preventDefault();
        payText = this.innerHTML;
        this.innerHTML = spinner;
        this.disabled = true;

        // Check if we're on mobile and have account number
        if (document.querySelector('[name="account_number"]')) {
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
                        let form = document.querySelector("#payment-form");
                        form.submit();
                    } else {
                        alert(response.error);
                        this.innerHTML = payText;
                        this.disabled = false;
                    }
                }
            });
            return;
        }

        const paymentMethod = document.querySelector('[name="pay_method"]:checked').value;

        if (paymentMethod === 'paypal') {
            // Continue with PayPal payment
            let form = document.querySelector("#payment-form");
            form.submit();
        } else {
            // Show card payment modal
            this.innerHTML = payText;
            this.disabled = false;
            $('#cardPaymentModal').modal('show');
            
            // Mount Stripe card element when modal is shown
            if (stripe && card) {
                // Add the card Element to the page.
                card.mount('#card-element');
                
                // Handle real-time validation errors from the card Element.
                card.on('change', function(event) {
                    const displayError = document.getElementById('card-errors');
                    if (event.error) {
                        displayError.textContent = event.error.message;
                    } else {
                        displayError.textContent = '';
                    }
                });
            }
        }
    });

    // Handle card payment form submission
    $('#card-payment-form').on('submit', function(e) {
        e.preventDefault();
        
        if (stripe && card) {
            // Handle Stripe payment
            handleStripePayment();
        } else {
            // Handle non-Stripe payment (fallback)
            handleFallbackPayment();
        }
    });

    function handleStripePayment() {
        const submitButton = document.getElementById('submit-payment');
        const buttonText = document.getElementById('button-text');
        const spinner = document.getElementById('spinner');
        
        // Disable the submit button and show loading state
        submitButton.disabled = true;
        buttonText.classList.add('d-none');
        spinner.classList.remove('d-none');
        
        // Create payment method
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
                // Show error to your customer
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
                
                // Re-enable the submit button
                submitButton.disabled = false;
                buttonText.classList.remove('d-none');
                spinner.classList.add('d-none');
            } else {
                // Add payment method to the main form and submit
                const mainForm = document.querySelector("#payment-form");
                const paymentMethodInput = document.createElement('input');
                paymentMethodInput.type = 'hidden';
                paymentMethodInput.name = 'payment_method_id';
                paymentMethodInput.value = result.paymentMethod.id;
                mainForm.appendChild(paymentMethodInput);

                // Close modal and submit main form
                $('#cardPaymentModal').modal('hide');
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

        // Close modal and submit main form
        $('#cardPaymentModal').modal('hide');
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

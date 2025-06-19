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

        // Also try Express Checkout Element as fallback/alternative
        initializeExpressCheckout(elements);

        // Add debug logging after initialization
        setTimeout(() => {
            debugPaymentButtons();
        }, 2000);
    }

    function initializePaymentRequest(elements) {
        // Get cart total from the page - try multiple selectors for mobile/desktop
        let cartSum = 0;
        const pageSumElement = document.getElementById('page-sum') ||
                              document.querySelector('.cart-total') ||
                              document.querySelector('[data-cart-sum]') ||
                              document.querySelector('#page-sum');

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

        if (cartSum <= 0) {
            console.log('PaymentRequest: Unable to determine cart total');
            return;
        }

        console.log('PaymentRequest: Cart total detected:', cartSum);

        // Create Payment Request with enhanced configuration for Google Pay/Apple Pay
        paymentRequest = stripe.paymentRequest({
            country: 'GB',
            currency: 'gbp',
            total: {
                label: 'Islamic Help Donation',
                amount: Math.round(cartSum * 100), // Convert to pence
            },
            requestPayerName: true,
            requestPayerEmail: true,
            // Disable Link to prioritize Google Pay/Apple Pay
            disableWallets: ['link']
        });

        // Create Payment Request Button with proper configuration
        const prButton = elements.create('paymentRequestButton', {
            paymentRequest: paymentRequest,
            style: {
                paymentRequestButton: {
                    type: 'donate', // Changed from 'default' to 'donate' for better UX
                    theme: 'dark',
                    height: '48px',
                },
            },
        });

        // Check if Payment Request is available (Google Pay / Apple Pay)
        paymentRequest.canMakePayment().then(function(result) {
            if (result) {
                console.log('PaymentRequest: Available payment methods:', result);

                // Check specifically for Google Pay and Apple Pay
                const hasGooglePay = result.googlePay;
                const hasApplePay = result.applePay;

                console.log('Google Pay available:', hasGooglePay);
                console.log('Apple Pay available:', hasApplePay);

                if (hasGooglePay || hasApplePay) {
                    const paymentRequestContainer = document.getElementById('payment-request-button');
                    const paymentRequestDivider = document.getElementById('payment-request-divider');
                    const expressContainer = document.getElementById('express-checkout-element');

                    // Check if Express Checkout is actually visible (not just display: block but has content)
                    const expressCheckoutVisible = expressContainer &&
                                                  expressContainer.style.display === 'block' &&
                                                  expressContainer.querySelector('button, [role="button"]');

                    if (paymentRequestContainer) {
                        if (!expressCheckoutVisible) {
                            // Use a timeout to allow Express Checkout to initialize first
                            setTimeout(() => {
                                const stillNeedPaymentRequest = !expressContainer ||
                                                               expressContainer.style.display !== 'block' ||
                                                               !expressContainer.querySelector('button, [role="button"]');

                                if (stillNeedPaymentRequest) {
                                    prButton.mount('#payment-request-button');
                                    paymentRequestContainer.style.display = 'block';
                                    if (paymentRequestDivider) {
                                        paymentRequestDivider.style.display = 'block';
                                    }
                                    console.log('PaymentRequest: Button mounted as fallback');
                                } else {
                                    console.log('PaymentRequest: Express Checkout working, PaymentRequest not needed');
                                }
                            }, 1000); // Wait longer than Express Checkout ready timeout
                        } else {
                            console.log('PaymentRequest: Express Checkout already visible with buttons');
                        }
                    } else {
                        console.error('PaymentRequest: Container #payment-request-button not found');
                    }
                } else {
                    console.log('PaymentRequest: Neither Google Pay nor Apple Pay available');
                }
            } else {
                console.log('PaymentRequest: No supported payment methods available');
            }
        }).catch(function(error) {
            console.error('PaymentRequest: Error checking availability:', error);
        });

        // Handle payment method creation from Payment Request
        paymentRequest.on('paymentmethod', function(ev) {
            console.log('PaymentRequest: Payment method created:', ev.paymentMethod);

            // Validate required form fields before processing payment
            if (!validateRequiredFields()) {
                ev.complete('fail');
                console.log('PaymentRequest: Validation failed');
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
                paymentMethodTypeInput.value = 'stripe';
                mainForm.appendChild(paymentMethodTypeInput);
            } else {
                existingPayMethodInput.value = 'stripe';
            }

            // Complete the payment request
            ev.complete('success');
            console.log('PaymentRequest: Payment completed successfully');

            // Submit the form
            setTimeout(() => {
                mainForm.submit();
            }, 100);
        });

        paymentRequest.on('cancel', function() {
            console.log('PaymentRequest: Payment cancelled by user');
        });
    }

    function initializeExpressCheckout(elements) {
        try {
            // Get cart total
            let cartSum = 0;
            const pageSumElement = document.getElementById('page-sum') ||
                                  document.querySelector('.cart-total') ||
                                  document.querySelector('[data-cart-sum]') ||
                                  document.querySelector('#page-sum');

            if (pageSumElement) {
                const sumText = pageSumElement.innerText || pageSumElement.textContent || '';
                cartSum = parseFloat(sumText.replace(/[^0-9.-]+/g,"")) || 0;
            }

            if (cartSum <= 0) {
                console.log('ExpressCheckout: Unable to determine cart total');
                return;
            }

            // Create Express Checkout Element with proper configuration
            const expressCheckoutElement = elements.create('expressCheckout', {
                paymentMethodCreation: 'manual',
                layout: {
                    maxColumns: 1,
                    maxRows: 1,
                    overflow: 'auto'
                }
            });

            // Try to mount Express Checkout Element
            const expressContainer = document.getElementById('express-checkout-element');
            if (expressContainer) {
                expressCheckoutElement.mount('#express-checkout-element');

                // Wait for the element to be ready and check if it has payment methods
                expressCheckoutElement.on('ready', function(event) {
                    console.log('ExpressCheckout: Element ready');
                    // Only show if there are actually payment methods available
                    setTimeout(() => {
                        const hasVisibleButtons = expressContainer.querySelector('button, [role="button"]');
                        if (hasVisibleButtons) {
                            expressContainer.style.display = 'block';
                            const divider = document.getElementById('payment-request-divider');
                            if (divider) {
                                divider.style.display = 'block';
                            }
                            console.log('ExpressCheckout: Buttons found and container shown');
                        } else {
                            console.log('ExpressCheckout: No buttons found, keeping container hidden');
                        }
                    }, 500); // Small delay to ensure buttons are rendered
                });

                expressCheckoutElement.on('click', function(event) {
                    console.log('ExpressCheckout: Button clicked:', event.expressPaymentType);
                });

                expressCheckoutElement.on('confirm', function(event) {
                    console.log('ExpressCheckout: Payment confirmed');

                    if (!validateRequiredFields()) {
                        event.complete('fail');
                        return;
                    }

                    // Add payment method to form
                    const paymentMethodInput = document.createElement('input');
                    paymentMethodInput.type = 'hidden';
                    paymentMethodInput.name = 'payment_method_id';
                    paymentMethodInput.value = event.paymentMethod.id;
                    mainForm.appendChild(paymentMethodInput);

                    // Set payment method
                    let payMethodInput = mainForm.querySelector('[name="pay_method"]');
                    if (!payMethodInput) {
                        payMethodInput = document.createElement('input');
                        payMethodInput.type = 'hidden';
                        payMethodInput.name = 'pay_method';
                        mainForm.appendChild(payMethodInput);
                    }
                    payMethodInput.value = 'stripe';

                    event.complete('success');

                    setTimeout(() => {
                        mainForm.submit();
                    }, 100);
                });

                expressCheckoutElement.on('cancel', function() {
                    console.log('ExpressCheckout: Payment cancelled');
                });

                console.log('ExpressCheckout: Element mounted, waiting for ready event');
            } else {
                console.log('ExpressCheckout: Container not found, using Payment Request only');
            }
        } catch (error) {
            console.error('ExpressCheckout: Error initializing:', error);
        }
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

    function debugPaymentButtons() {
        console.log('=== Payment Button Debug ===');

        const expressContainer = document.getElementById('express-checkout-element');
        const paymentRequestContainer = document.getElementById('payment-request-button');
        const divider = document.getElementById('payment-request-divider');

        console.log('Express Checkout Container:', {
            exists: !!expressContainer,
            display: expressContainer?.style.display,
            hasContent: !!expressContainer?.innerHTML,
            hasButtons: !!expressContainer?.querySelector('button, [role="button"]'),
            innerHTML: expressContainer?.innerHTML
        });

        console.log('Payment Request Container:', {
            exists: !!paymentRequestContainer,
            display: paymentRequestContainer?.style.display,
            hasContent: !!paymentRequestContainer?.innerHTML,
            hasButtons: !!paymentRequestContainer?.querySelector('button, [role="button"]'),
            innerHTML: paymentRequestContainer?.innerHTML
        });

        console.log('Divider:', {
            exists: !!divider,
            display: divider?.style.display
        });

        console.log('=== End Debug ===');
    }

    if (stringCounter && notesInput) {
        stringCounter.innerText = `${notesInput.value.length}/${notesInput.maxLength}`;
        notesInput.addEventListener("input", e => {
            const maxLength = +e.target.maxLength;
            stringCounter.innerText = `${e.target.value.length}/${maxLength}`;
        });
    }
});

$(function() {
    const spinner = `<div class="spinner-border text-light" role="status">
  <span class="sr-only">Loading...</span>
</div>`;
    let payText = "";
    const stringCounter = document.querySelector(".string-counter");
    const notesInput = document.querySelector('[name="notes"]');

    // Card number formatting
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

    // Expiry date formatting
    function formatExpiryDate(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length === 1 && Number(value) > 2) value = "0" + value;
        if (value.length === 2 && Number(value) > 12) value = "0" + value;
        if (value.length > 2) {
            value = value.substring(0, 2) + ' / ' + value.substring(2, 4);
        }
        input.value = value;
    }

    // CVV formatting
    function formatCVV(input) {
        let value = input.value.replace(/\D/g, '');
        input.value = value.substring(0, 3);
    }

    // Add input event listeners for formatting
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
        }
    });

    // Handle card payment form submission
    $('#card-payment-form').on('submit', function(e) {
        e.preventDefault();
        
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
    });

    if (stringCounter && notesInput) {
        stringCounter.innerText = `${notesInput.value.length}/${notesInput.maxLength}`;
        notesInput.addEventListener("input", e => {
            const maxLength = +e.target.maxLength;
            stringCounter.innerText = `${e.target.value.length}/${maxLength}`;
        });
    }
});

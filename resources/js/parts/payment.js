$(function() {
    const spinner = `<div class="spinner-border text-light" role="status">
  <span class="sr-only">Loading...</span>
</div>`;
    let payText = "";
    const stringCounter = document.querySelector(".string-counter");
    const notesInput = document.querySelector('[name="notes"]');

    $(document).on("change", '[name="pay_method"]', function() {
        $("#payment-card").toggleClass("d-none");
    });

    $("#cart-pay").on("click", function(e) {
        payText = this.innerHTML;
        this.innerHTML = spinner;
        this.disabled = true;
        if (document.querySelector('[name="account_number"]')) {
            e.preventDefault();

            let accountNumber = document.querySelector(
                '[name="account_number"]'
            ).value;
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
        } else {
            let form = document.querySelector("#payment-form");
            form.submit();
        }
    });

    if (stringCounter && notesInput) {
        stringCounter.innerText = `${notesInput.value.length}/${notesInput.maxLength}`;
        notesInput.addEventListener("input", e => {
            const maxLength = +e.target.maxLength;
            stringCounter.innerText = `${e.target.value.length}/${maxLength}`;
        });
    }
});

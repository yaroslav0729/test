$(function () {

    function sendFormAndRefreshCard(form)
    {
        var formData = new FormData(form[0]);

        let lastAmount = form.find('input[name="amount"]').val()
        let lastPeriod = form.find('select[name="period"]').val()

        $('#add_to_cart_popup .amount').text(lastAmount)
        $('#add_to_cart_popup .period').text(lastPeriod)

        $.ajax({
            url     : form.attr('action'),
            type    : form.attr('method'),
            data    : formData,
            processData: false,
            contentType: false,
            success : function (response, textStatus, jqXHR)
            {
                if (response.success) {

                    let newCart = $('.modal-body', response.cart_html)
                    $('#cartModal .modal-body').html(newCart.html())

                    let newCartDonate = $(response.cart_donate)
                    $('.about-donation').html(newCartDonate.html())

                    $('.basket #sum').text(response.sum)

                    if (response.sum > 0) {
                        $('.basket span').removeClass('d-none')
                    } else {
                        $('.basket span').addClass('d-none')
                    }
                }
            },
            error: function(response) {

                toastr.error('Unknown error ','Error')
            }
        });
    }

    $(document).on('click', '#cartModal .btn-remove', function (e) {
        e.preventDefault()

        var form = $(this).closest('form')

        //form.submit()
        sendFormAndRefreshCard(form)
    })

    $(document).on('click', '.about-donation .btn-remove', function (e) {
        e.preventDefault()

        var form = $(this).closest('form')

        //form.submit()
        sendFormAndRefreshCard(form)
    })

    $(document).on('submit', '#donate_modal form', function (e) {
        e.preventDefault()

        var form = $(this)

        sendFormAndRefreshCard(form)

        $('#donate_modal').modal('hide');

        $('#add_to_cart_popup').fadeIn().delay(5000).fadeOut();
        
    })

    $(document).on('click', '[donate-btn]', function (e) {
        e.preventDefault()
        //toastr.success('message')

        let form = $(this).closest('form')

        let amount = form.find('input[name="amount"]').val()

        if (Number.isNaN(parseInt(amount))) {
            toastr.warning('Select amount first, please!')
            return
        } 

        let modal = $('#donate_modal')
        modal.find('input[name="amount"]').val(amount)

        let checkedEL = form.find('input[name="price"]:checked').closest('[select-amount]')
        let amountId = checkedEL.data('amount_id')

        countryId = $('[amount-countries][data-amount_id="' + amountId +  '"] select').val()
        modal.find('input[name="campaigns"]').val(countryId)

        let categoriesEl = form.find('select[name="categories"]')
        let modalCategEl = modal.find('select[name="categories"]')

        modalCategEl.html(categoriesEl.html())
        let selectedCateg = categoriesEl.val()
        modalCategEl.find('option[value="' + selectedCateg + '"]').attr('selected','selected')

        modal.modal('show')
    });

});
$(function () {

    var cartTimeout;

    $(document).on('change', '#cartModal input[type="number"]', function (e) {
        e.preventDefault()

        clearTimeout(cartTimeout);
        cartTimeout = setTimeout(updatePopupCart, 1000);
    });

    $(document).on('change', '#about-donation input[type="number"]', function (e) {
        e.preventDefault()

        clearTimeout(cartTimeout);
        cartTimeout = setTimeout(updateAboutCart, 1000);
    });

    function updateAboutCart()
    {
        let cartEl = $('#about-donation')
        let numbers = cartEl.find('input[type="number"]')

        let cart = []

        numbers.each(function () {
            let quant = $(this).val()
            let id = $(this).data('id')

            cart.push({id: id, quantity: quant})
        });

        $.ajax({
            url     : '/cart/refresh_quantity',
            type    : 'post',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data    : {
                cart: cart
            },
            success : function (response, textStatus, jqXHR)
            {
                if (response.success) {
                    refreshCardAddHtml(response)
                }
            },
            error: function(response) {

                toastr.error('Unknown error ','Error')
            }
        });
    }

    function updatePopupCart()
    {
        let cartEl = $('#cartModal')
        let numbers = cartEl.find('input[type="number"]')

        let cart = []

        numbers.each(function () {
            let quant = $(this).val()
            let id = $(this).data('id')

            cart.push({id: id, quantity: quant})
        });

        $.ajax({
            url     : '/cart/refresh_quantity',
            type    : 'post',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data    : {
                cart: cart
            },
            success : function (response, textStatus, jqXHR)
            {
                if (response.success) {
                    refreshCardAddHtml(response)
                }
            },
            error: function(response) {

                toastr.error('Unknown error ','Error')
            }
        });
    }

    $(document).on('click', '[zakat-donate-btn]', function (e) {
        e.preventDefault()

        let amount = $('input[name="zakat_value"]').val()

        $.ajax({
            url     : '/cart/add',
            type    : 'post',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data    : {
                amount: amount,
                note: "Zakat calculator donation"
            },
            success : function (response, textStatus, jqXHR)
            {
                if (response.success) {
                    refreshCardAddHtml(response)
                }
            },
            error: function(response) {

                toastr.error('Unknown error ','Error')
            }
        });
    });


    $(function() {
        $('.btn-modal-quick-donation').on('click', function () {
            $('.modal-quick-donation').show();
            $('.modal-quick-donation .close').on('click', function () {
                $('.modal-quick-donation').hide();
            })
        })
    });

    $(document).on('click', '[quick-donation] .btn_sbmt', function (e) {
        e.preventDefault()
        let form = $(this).closest('form')
        sendFormAndRefreshCard(form)
        //form.submit()

        $('.modal-quick-donation').hide(); // mobile version
        $('#add_to_cart_popup').fadeIn().delay(5000).fadeOut();
    });

    $(document).on('click', '[tiles-popup] .btn_sbmt', function (e) {
        e.preventDefault()

        let form = $(this).closest('form')
        
        let type = form.find('select[name="period"]').val()
        let price

        if (type === 'single') {
            price = form.find('select[name="price_single"]').val()
        } else {
            price = form.find('select[name="price_monthly"]').val()
        }

        form.find('input[name="amount"]').val(price)

        //form.submit()
        sendFormAndRefreshCard(form)
        $('[tiles-popup]').addClass('d-none')
        $('#add_to_cart_popup').fadeIn().delay(5000).fadeOut();
    });

    function refreshCardAddHtml(response)
    {
        let newCart = $('.modal-body', response.cart_html)
        $('#cartModal .modal-body').html(newCart.html())

        let newCartDonate = $(response.cart_donate)
        $('.about-donation').html(newCartDonate.html())

        //$("input[type='number']").inputSpinner()
        $("[input_number_spinner]").inputSpinner()

        $('.basket #sum').text(response.sum)

        if (response.sum > 0) {
            $('.basket span').removeClass('d-none')
        } else {
            $('.basket span').addClass('d-none')
        }
    }

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
                    refreshCardAddHtml(response)
                }
            },
            error: function(response) {

                toastr.error('Unknown error ','Error')
            }
        });
    }

    $(document).on('click', '#cartModal a.btn_checkout', function (e) {
        $('#cartModal').modal('hide');
    })

    $(document).on('click', '#cartModal .btn-remove', function (e) {
        e.preventDefault()

        var form = $(this).closest('form')

        //form.submit()
        sendFormAndRefreshCard(form)
    })

    $(document).on('click', '#clear_all_btn', function (e) {
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
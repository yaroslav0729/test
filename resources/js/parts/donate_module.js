$(function () {

    //~~~~~~~~~~~~ show countries dropdown if click on amount ~~~~

    $(document).on('click', '[select-amount]', function () {
        let amountId = $(this).data('amount_id')
        $('[amount-countries]').addClass('d-none')
        let countriesEl = $('[amount-countries][data-amount_id="' + amountId +'"]');
        countriesEl.removeClass('d-none')

        let price = $(this).find('input[name="price"]').val()
        $(this).closest('form').find('input[name="amount"]').val(price)

        changeDonateCategDropdown(countriesEl)
    });

    $(document).on('change', '[amount-countries]', function () {
        changeDonateCategDropdown(this)
    });

    function changeDonateCategDropdown(element)
    {
        let campaign = $(element).find('select[name="campaign"]').val()

        let options = $('#donate_module_options').html()
        options = JSON.parse(options)

        let categories = options[campaign]['categories']

        let categHtml = ''

        for (var categoryIndex in categories) {
            let category = categories[categoryIndex]
            categHtml = categHtml + '<option value="' + category +  '">' + category  + '</option>'
        }

        let categEl = $(element).closest('form').find('select[name="categories"]')
        categEl.html(categHtml)   
    }

    $(document).on('change', 'select[name="currency"]', function () {
        let sign = $(this).find('option:selected').data('sign')

        console.log(sign)

        $('object.currency_sign').text(sign)
        $('input[name="amount"]').attr('placeholder', sign + '  Enter amount')
    });

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    $(document).on('click', '[select-appeal-tab]', function () {
        $('[appeal-tab]').addClass('d-none')

        let tabClass = $(this).data('tab')
        $('div.' + tabClass).removeClass('d-none')
    });

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
})
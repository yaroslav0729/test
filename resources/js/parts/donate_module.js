$(function () {

    //~~~~~~~~~~~~ show countries dropdown if click on amount ~~~~

    

    $(document).on('click', '[select-appeal-tab]', function () {
        let period = $(this).data('period')

        var form = $(this).closest('form')
        form.find('input[name="period"]').val(period)
    });

    $(document).on('click', '[select-amount]', function () {

        let form = $(this).closest('form')
        let amountId = $(this).data('amount_id')
        $('[amount-countries]').addClass('d-none')
        $('[amount-countries] select').attr('disabled', 'disabled');
        let countriesEl = $(form).find(' [amount-countries][data-amount_id="' + amountId +'"]');
        let countOpt = $('option', countriesEl).length

        if (countOpt > 1) {
            countriesEl.removeClass('d-none')  
        }

        countriesEl.find('select').removeAttr('disabled');

        let price = $(this).find('input[name="price"]').val()
        $(this).closest('form').find('input[name="amount"]').val(price)

        changeDonateCategDropdown(countriesEl)
    });

    $(document).on('change', '[amount-countries]', function () {
        changeDonateCategDropdown(this)
    });

    function changeDonateCategDropdown(element)
    {
        let campaign = $(element).find('select[name="campaigns"]').val()

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
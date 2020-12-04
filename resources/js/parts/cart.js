$(function () {

    $(document).on('click', '#cartModal .btn-remove', function (e) {
        e.preventDefault()

        $(this).closest('form').submit()
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

        let countries = $('[amount-countries][data-amount_id="' + amountId +  '"] select').html()
        console.log(countries)
        
        
        modal.find('select[name="campaigns"]').html(countries)

        let categories = form.find('select[name="categories"]').html()
        modal.find('select[name="categories"]').html(categories)

        modal.modal('show')
    });

});
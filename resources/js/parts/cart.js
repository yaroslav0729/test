$(function () {

    function sendFormAndRefreshCard(form)
    {
        var formData = new FormData(form[0]);

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
                }
            },
            error: function(response) {

                toastr.error('Unknown error ','Error')
            }
        });
    }

    $(document).on('click', '#cartModal .btn-remove', function (e) {
        e.preventDefault()

        //var form = $(this).closest('form')
        //form.submit()

        var form = $(this).closest('form')
        sendFormAndRefreshCard(form)
    })

    // $(document).on('submit', '#donate_modal', function (e) {
    //     e.preventDefault()

    //     console.log('submit')

    //     var form = $(this)

    //     sendFormAndRefreshCard(form)

    //     $('#donate_modal').modal('hide');
    // })

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
        
        modal.find('select[name="campaigns"]').html(countries)

        let categories = form.find('select[name="categories"]').html()
        modal.find('select[name="categories"]').html(categories)

        modal.modal('show')
    });

});
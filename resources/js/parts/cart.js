$(function () {

    var cartTimeout;
    const thankYouPage = $('.thank-you-page');

    /*----------- hide basket in the Thank you Page (mobile) ------------*/
    if ( thankYouPage.length > 0 && $(window).width() <= '995') {
        $('.basket').addClass('d-none');
    }

    function cartAnim(x) {
        $('#cartModal .modal-dialog').attr('class', 'modal-dialog animated ' + x);
    };

    $(document).on('hide.bs.modal', '#cartModal', function (e) {
        $('header .basket').removeClass('open')
    })
    $(document).on('show.bs.modal', '#cartModal', function (e) {
        $('header .basket').addClass('open')

        cartAnim('fadeInDown');
    })

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

    /*----------- change button donate after click (mobile) ------------*/
    $(document).on('click', '.add-related', function () {
        selectItemToRed($(this));
    });

    $(document).on('click', '[zakat-donate-btn]', function (e) {
        e.preventDefault()

        let amount = $('input[name="zakat_value"]').val()
        let category = $('#zakat-category').val();

        if (amount < 5) {
            //toastr.warning('Sorry, your donation amount must be at least £5')
            $('.modal-at-least-5').modal('show')
            return
        }

        $('#add_to_cart_popup .amount').text(convertMonetary(amount));
        $('#add_to_cart_popup .period').text('Single');

        $.ajax({
            url     : '/cart/add',
            type    : 'post',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data    : {
                amount: amount,
                categories: category,
                note: "Zakat calculator donation"
            },
            success : function (response, textStatus, jqXHR)
            {
                if (response.success) {
                    refreshCardAddHtml(response)
                    $('#add_to_cart_popup').fadeIn().delay(5000).fadeOut();
                }
            },
            error: function(response) {

                toastr.error('Unknown error ','Error')
            }
        });
    });

    //~~~~~~~~~~~~~~~~~~ Convert float value to string format "1'000.00" ~~~~~~~~~~~~~~~~~~~~
    function convertMonetary(value) {
        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "'");
    }


    $(function() {
        $('.btn-modal-quick-donation').on('click', function () {
            $('.modal-quick-donation').fadeIn( "fast" );
            $('.modal-quick-donation .close').on('click', function () {
                $('.modal-quick-donation').hide();
            })
        })
    });

    $(document).on('click', '[quick-donation] .btn_sbmt', function (e) {
        e.preventDefault()
        let form = $(this).closest('form')

        let amount = form.find('input[name="amount"]').val()

        if (amount < 5) {
            $('.modal-at-least-5').modal('show')
            return
        }

        sendFormAndRefreshCard(form)
        //form.submit()

        $('.modal-quick-donation').hide(); // mobile version
        $('#add_to_cart_popup').fadeIn().delay(5000).fadeOut();
    });

    $(document).on('click', '[quick-donation] .btn-period', function (e) {
        $('[quick-donation] .btn-period').removeClass('active');
        $(this).addClass('active');
        var period = $(this).data('period')
        var form = $(this).closest('form');

        form.find('select[name="period"]').val(period);
    });

    $(document).on('click', '[tiles-popup] .btn_sbmt', function (e) {
        e.preventDefault()

        let form = $(this).closest('form');
        let categories = form.find('select[name="categories"]').val();

        const elChecked = $(this).closest('.top-bar').find('.text-value');

        let type = form.find('select[name="period"]').val()
        let price

        if (type === 'single') {
            price = form.find('select[name="price_single"]').val()
        } else {
            price = form.find('select[name="price_monthly"]').val()
        }


        form.find('input[name="amount"]').val(price);

        if ($(elChecked).length) {
            $(elChecked).html('£' + price + ' +' + categories);
        }

        sendFormAndRefreshCard(form, this);

        $('#proj_tiles_modal_popup').modal('hide') // for mobile version
        $('[tiles-popup]').addClass('d-none')
        $('#add_to_cart_popup').fadeIn().delay(5000).fadeOut();
    });

    //~~~~~~~~~~~~~~~~~~ Fill block to red colour after click (mobile) ~~~~~~~~~~~~~~~~~~~~
    function selectItemToRed(element)
    {
        const blockProject = element.closest('.descr');
        const icon = $(blockProject).find('i');

        $(icon).removeClass('moon-icons-plus');
        $(icon).addClass('moon-icons-check');
        $(blockProject).addClass('bg-btn-red');

    }

    function refreshCardAddHtml(response)
    {
        let newCart = $('.modal-body', response.cart_html)
        $('#cartModal .modal-body').html(newCart.html())

        let newCartDonate = $(response.cart_donate)
        $('.about-donation').html(newCartDonate.html())

        $("[input_number_spinner]").inputSpinner()

        $('.basket #sum').text(response.sum)

        if (response.sum > 0) {
            $('.basket span').removeClass('d-none')

            $('.basket').addClass('bell-animate')
            setTimeout(function() {
                $('.basket').removeClass('bell-animate');
            }, 3100 );

        } else {
            $('.basket span').addClass('d-none')
            $('.basket').removeClass('bell-animate')
        }
    }

    function sendFormAndRefreshCard(form)
    {
        var formData = new FormData(form[0]);

        let lastAmount = form.find('input[name="amount"]').val()
        let lastPeriod = form.find('select[name="period"]').val()

        if (lastPeriod === undefined) {
            lastPeriod = form.find('input[name="period"]').val()
        }

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
                    refreshRelatedProjects();
                }
            },
            error: function(response) {
                toastr.error('Unknown error ','Error')
            }
        });
    }

    refreshRelatedProjects();

    function refreshRelatedProjects() {
        let projects = $('.project');
        let projectsChecked = $('.add-width');
        let projectsCheckedMobile = $('.add');
        let arrProjectsId = [];

        projects.each(function () {
            arrProjectsId.push(parseInt($(this).val()));
        });

        projectsChecked.each(function () {
            let id = $(this).data('id');
            if ($.inArray(parseInt(id), arrProjectsId) == -1) {
                removeCheckedToProject($(this));
            } else {
                addCheckedToProject($(this));
            }
        });

        projectsCheckedMobile.each(function () {
            let id = $(this).data('id');
            let elDescr = $(this).closest('.descr');
            if ($(elDescr).length) {
                if ($.inArray(parseInt(id), arrProjectsId) == -1) {
                    removeCheckedToProjectMobile($(this));
                } else {
                    addCheckedToProjectMobile($(this));
                }
            }
        });
    }


    //~~~~~~~~~~~~~~~~~~ Add and Clear project from 'checked' (mobile) ~~~~~~~~~~~~~~~~~~~~
    function addCheckedToProjectMobile(element) {
        let descrEl = element.closest('.descr');
        if (descrEl.length) {
            $(descrEl).addClass('bg-btn-red');
            $(descrEl).find('i').addClass('moon-icons-check')
            $(descrEl).find('i').removeClass('moon-icons-plus')
        }
    }

    function removeCheckedToProjectMobile(element) {
        let descrEl = element.closest('.descr');
        if (descrEl.length) {
            $(descrEl).removeClass('bg-btn-red');
            $(descrEl).find('i').removeClass('moon-icons-check')
            $(descrEl).find('i').addClass('moon-icons-plus')
        }
    }

    //~~~~~~~~~~~~~~~~~~ Add and Clear project from 'checked' ~~~~~~~~~~~~~~~~~~~~
    function removeCheckedToProject(element) {
        if (!element.hasClass('d-none')) {
            const elItem = element.closest('.item');
            element.addClass('d-none');
            $(elItem).find('.descr').removeClass('bg-btn-red');
            $(elItem).find('.add').removeClass('d-none');
        }
    }

    function addCheckedToProject(element) {
        if (element.hasClass('d-none')) {
            const elItem = element.closest('.item');
            element.removeClass('d-none');
            $(elItem).find('.descr').addClass('bg-btn-red');
            $(elItem).find('.add').addClass('d-none');
        }
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

    $(document).on('click', '[donate-btn]', function (e) {
        e.preventDefault()

        let form = $(this).closest('form')

        let amount = form.find('input[name="amount"]').val()

        if (amount < 5) {
            //toastr.warning('Sorry, your donation amount must be at least £5')
            $('.modal-at-least-5').modal('show')
            return
        }

        //form.submit();
        sendFormAndRefreshCard(form)
        $('#add_to_cart_popup').fadeIn().delay(5000).fadeOut();
    });
});

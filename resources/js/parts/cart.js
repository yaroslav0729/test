import Swal from "sweetalert2";

export function refreshCardAddHtml(response) {
    let newCart = $(".modal-body", response.cart_html);
    $("#cartModal .modal-body").html(newCart.html());

    let newCartDonate = $(response.cart_donate);
    $(".about-donation").html(newCartDonate.html());

    $("[input_number_spinner]").inputSpinner();

    $(".basket #sum").text(response.sum_for_view);

    if (response.sum > 0) {
        $(".basket span").removeClass("d-none");
        $(".basket-mobile").removeClass("d-none");

        $(".basket").addClass("bell-animate");
        setTimeout(function () {
            $(".basket").removeClass("bell-animate");
        }, 3100);
    } else {
        $(".basket span").addClass("d-none");
        $(".basket-mobile").addClass("d-none");
        $(".basket").removeClass("bell-animate");
    }
}

export function openCart() {
    $('#cartBackdrop').fadeIn('slow');
    $('#cartModal').addClass('open');
    document.body.style.overflow = 'hidden';
}

export function hideCart() {
    $('#cartBackdrop').fadeOut('slow');
    $('#cartModal').removeClass('open');
    document.body.style.overflow = '';
}

export function number_format(
    number,
    decimals = 0,
    dec_point = ".",
    thousands_sep = ","
) {
    let sign = number < 0 ? "-" : "";

    let s_number =
        Math.abs(parseInt((number = (+number || 0).toFixed(decimals)))) +
        "";
    let len = s_number.length;
    let tchunk = len > 3 ? len % 3 : 0;

    let ch_first = tchunk ? s_number.substr(0, tchunk) + thousands_sep : "";
    let ch_rest = s_number
        .substr(tchunk)
        .replace(/(\d\d\d)(?=\d)/g, "$1" + thousands_sep);
    let ch_last = decimals
        ? dec_point +
        (Math.abs(number) - s_number).toFixed(decimals).slice(2)
        : "";

    return sign + ch_first + ch_rest + ch_last;
}

$(function () {
    if(window.location.search === '?about-donation=true') {
        const cartSection = document.querySelector('.about-donation');
        window.scroll(0,0)
        $( document ).on( "ready", function() {
                cartSection.scrollIntoView({block: 'start', behavior: 'smooth', inline: 'center'});
        });
    }

    var cartTimeout;
    const thankYouPage = $(".thank-you-page");

    /*----------- hide basket in the Thank you Page (mobile) ------------*/
    if (thankYouPage.length > 0 && $(window).width() <= "995") {
        $(".basket").addClass("d-none");
    }

    $(document).on("change", '#cartModal input[type="number"]', function (e) {
        e.preventDefault();

        clearTimeout(cartTimeout);
        cartTimeout = setTimeout(updatePopupCart, 1000);
    });
    $(document).on("change", '#donate-page-cart input[type="number"]', function (
        e
    ) {
        e.preventDefault();

        clearTimeout(cartTimeout);
        cartTimeout = setTimeout(updateDonatePageCart, 1000);
    });

    $(document).on("change", '#about-donation input[type="number"]', function (
        e
    ) {
        e.preventDefault();

        clearTimeout(cartTimeout);
        cartTimeout = setTimeout(updateAboutCart, 1000);
    });

    function updateAboutCart() {
        let cartEl = $("#about-donation");
        let numbers = cartEl.find('input[type="number"]');

        let cart = [];

        numbers.each(function () {
            let quant = $(this).val();
            let id = $(this).data("id");

            cart.push({ id: id, quantity: quant });
        });

        $.ajax({
            url: "/cart/refresh_quantity",
            type: "post",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
                cart: cart
            },
            success: function (response, textStatus, jqXHR) {
                if (response.success) {
                    refreshCardAddHtml(response);
                }else if (!response.success && response.error === 'big_monthly_donate') {
                    refreshCardAddHtml(response);
                    Swal.fire({
                        html: '<h5 style="padding: 20px 0">For donations of this value <br> please contact our team on 0121 446 568</h5>',
                        width: '40em',
                        confirmButtonText: 'Ok'
                    })
                }
            },
            error: function (response) {
                toastr.error("Unknown error ", "Error");
            }
        });
    }
    // #donate-page-cart
    function updateDonatePageCart() {
        let cartEl = $("#donate-page-cart");
        let numbers = cartEl.find('input[type="number"]');

        let cart = [];

        numbers.each(function () {
            let quant = $(this).val();
            let id = $(this).data("id");

            cart.push({ id: id, quantity: quant });
        });

        $.ajax({
            url: "/cart/refresh_quantity",
            type: "post",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
                cart: cart
            },
            success: function (response, textStatus, jqXHR) {
                if (response.success) {
                    refreshDonatePageCart(response);
                }else if (!response.success && response.error === 'big_monthly_donate') {
                    refreshDonatePageCart(response);
                    Swal.fire({
                        html: '<h5 style="padding: 20px 0">For donations of this value <br> please contact our team on 0121 446 568</h5>',
                        width: '40em',
                        confirmButtonText: 'Ok'
                    })
                }
            },
            error: function (response) {
                toastr.error("Unknown error ", "Error");

            }
        });
    }

    function updatePopupCart() {
        let cartEl = $("#cartModal");
        let numbers = cartEl.find('input[type="number"]');

        let cart = [];

        numbers.each(function () {
            let quant = $(this).val();
            let id = $(this).data("id");

            cart.push({ id: id, quantity: quant });
        });

        $.ajax({
            url: "/cart/refresh_quantity",
            type: "post",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
                cart: cart
            },
            success: function (response, textStatus, jqXHR) {
                if (response.success) {
                    refreshCardAddHtml(response);
                }else if (!response.success && response.error === 'big_monthly_donate') {
                    refreshCardAddHtml(response);
                    Swal.fire({
                        html: '<h5 style="padding: 20px 0">For donations of this value <br> please contact our team on 0121 446 568</h5>',
                        width: '40em',
                        confirmButtonText: 'Ok'
                    })
                }
            },
            error: function (response) {
                toastr.error("Unknown error ", "Error");
            }
        });
    }

    /*----------- change button donate after click (mobile) ------------*/
    $(document).on("click", ".add-related", function () {
        selectItemToRed($(this));
    });

    $(document).on("click", "[zakat-donate-btn]", function (e) {
        e.preventDefault();

        let amount = $('input[name="zakat_value"]').val();
        let category = $("#zakat-category").val();

        if (amount < 5) {
            //toastr.warning('Sorry, your donation amount must be at least £5')
            $(".modal-at-least-5").modal("show");
            return;
        }

        $.ajax({
            url: "/cart/add",
            type: "post",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: {
                amount: amount,
                categories: category,
                note: "Zakat calculator donation"
            },
            success: function (response, textStatus, jqXHR) {
                if (response.success) {
                    $("#add_to_cart_popup .amount").text(convertMonetary(amount));
                    $("#add_to_cart_popup .period").text("Single");
                    refreshCardAddHtml(response);
                    showCartPopup();
                }else if (!response.success && response.error === 'big_monthly_donate') {
                    Swal.fire({
                        html: '<h5 style="padding: 20px 0">For donations of this value <br> please contact our team on 0121 446 568</h5>',
                        width: '40em',
                        confirmButtonText: 'Ok'
                    })
                }
            },
            error: function (response) {
                toastr.error("Unknown error ", "Error");
            }
        });
    });

    //~~~~~~~~~~~~~~~~~~ Convert float value to string format "1'000.00" ~~~~~~~~~~~~~~~~~~~~
    function convertMonetary(value) {
        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $(function () {
        $(".btn-modal-quick-donation").on("click", function () {
            $(".modal-quick-donation").addClass("show");
            setTimeout(() => {
                $(".modal-quick-donation").addClass("showed");
            }, 1000);
            $(".modal-quick-donation .close").on("click", function () {
                $(".modal-quick-donation").addClass("hidding");
                $(".modal-quick-donation").removeClass("show");
                setTimeout(() => {
                    $(".modal-quick-donation").removeClass("hidding");
                    $(".modal-quick-donation").removeClass("showed");
                }, 1000);
            });
        });
    });

    $(document).on("click", "[quick-donation] .btn_sbmt", function (e) {
        e.preventDefault();
        let form = $(this).closest("form");
        let amount = form.find('input[name="amount"]').val();

        if (amount < 5) {
            $(".modal-at-least-5").modal("show");
            return;
        }

        sendFormAndRefreshCard(form, true);

        //form.submit()

        // $(".modal-quick-donation").addClass("hidding");
        // $(".modal-quick-donation").removeClass("show");
        // setTimeout(() => {
        //     $(".modal-quick-donation").removeClass("hidding");
        //     $(".modal-quick-donation").removeClass("showed");
        // }, 1000); // mobile version
    });

    $(document).on("click", "[quick-donation] .btn-period", function (e) {
        $("[quick-donation] .btn-period").removeClass("active");
        $(this).addClass("active");
        var period = $(this).data("period");
        var form = $(this).closest("form");

        form.find('select[name="period"]').val(period);
    });

    $(document).on("click", "[tiles-popup] .btn_sbmt", function (e) {
        e.preventDefault();

        let form = $(this).closest("form");
        let categories = form.find('select[name="categories"]').val();

        const elChecked = $(this)
            .closest(".top-bar")
            .find(".text-value");

        let type = form.find('select[name="period"]').val();
        let price;

        if (type === "single") {
            price = form.find('select[name="price_single"]').val();
        } else {
            price = form.find('select[name="price_monthly"]').val();
        }

        form.find('input[name="amount"]').val(price);

        if ($(elChecked).length) {
            $(elChecked).html("£" + price + " +" + categories);
        }

        sendFormAndRefreshCard(form, true);

        $("#proj_tiles_modal_popup").modal("hide"); // for mobile version
        $("[tiles-popup]").addClass("d-none");
    });

    //~~~~~~~~~~~~~~~~~~ Fill block to red colour after click (mobile) ~~~~~~~~~~~~~~~~~~~~
    function selectItemToRed(element) {
        const blockProject = element.closest(".descr");
        const icon = $(blockProject).find("i");

        $(icon).removeClass("moon-icons-plus");
        $(icon).addClass("moon-icons-check");
        $(blockProject).addClass("bg-btn-red");
    }

    function refreshCardAddHtml(response) {
        console.log(response.cart_html);

        let newCart = $(".modal-body", response.cart_html);
        $("#cartModal .modal-body").html(newCart.html());

        let newCartDonate = $(response.cart_donate);
        $(".about-donation").html(newCartDonate.html());

        $("[input_number_spinner]").inputSpinner();

        $(".basket #sum").text(response.sum_for_view);
        console.log(response.commission)
        $("#page-sum-fee").text(response.commission);

        $('.cart-close').on('click', hideCart);

        $('[name="upsell"]').on('change', function () {
            addUpsellToCart();
        });

        if (response.sum > 0) {
            $(".basket span").removeClass("d-none");
            $(".basket-mobile").removeClass("d-none");

            $(".basket").addClass("bell-animate");
            setTimeout(function () {
                $(".basket").removeClass("bell-animate");
            }, 3100);
        } else {
            $(".basket span").addClass("d-none");
            $(".basket-mobile").addClass("d-none");
            $(".basket").removeClass("bell-animate");
        }
    }

    function refreshDonatePageCart(response) {
        $(".basket #sum").text(response.sum_for_view);
        $("#donate-page-cart #page-sum").text(response.sum_for_view);
        $("#page-sum-fee").text(response.commission);
        $('#commission').text('(+£'+response.commission+')')

        if (response.sum > 0) {
            $(".basket span").removeClass("d-none");
            $(".basket-mobile").removeClass("d-none");

            $(".basket").addClass("bell-animate");
            setTimeout(function () {
                $(".basket").removeClass("bell-animate");
            }, 3100);
        } else {
            $(".basket span").addClass("d-none");
            $(".basket-mobile").addClass("d-none");
            $(".basket").removeClass("bell-animate");
        }
    }

    function addUpsellToCart() {
        const $csrfField = $('form.cart-upsell input[name="_token"]');
        const $label = $('.cart-upsell label');
        $.ajax({
            url: $label.data('url'),
            method: 'POST',
            data: {
                '_token': $csrfField.val(),
            },
            success: function (response) {
                if (response.success) {
                    refreshCardAddHtml(response);
                    refreshRelatedProjects();
                    openCart();
                }
            }
        })
    }


    $('[name="upsell"]').on('change', function () {
        addUpsellToCart();
    });

    function sendFormAndRefreshCard(form, showPopup = false) {
        var formData = new FormData(form[0]);

        let lastAmount = form.find('input[name="amount"]').val();
        let lastPeriod = form.find('select[name="period"]').val();

        if (lastPeriod === undefined) {
            lastPeriod = form.find('input[name="period"]').val();
        }

        $.ajax({
            url: form.attr("action"),
            type: form.attr("method"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response, textStatus, jqXHR) {
                if (response.success) {
                    refreshCardAddHtml(response);
                    refreshRelatedProjects();
                    openCart();
                }else if (!response.success && response.error === 'big_monthly_donate') {
                    Swal.fire({
                        html: '<h5 style="padding: 20px 0">For donations of this value <br> please contact our team on 0121 446 568</h5>',
                        width: '40em',
                        confirmButtonText: 'Ok'
                    })
                }
            },
            error: function (response) {
                toastr.error("Unknown error ", "Error");
            }
        });
    }

    function removeItemFromDonatePageCart(form) {
        var formData = new FormData(form[0]);

        let lastAmount = form.find('input[name="amount"]').val();
        let lastPeriod = form.find('select[name="period"]').val();

        if (lastPeriod === undefined) {
            lastPeriod = form.find('input[name="period"]').val();
        }

        $("#add_to_cart_popup .amount").text(
            number_format(lastAmount, 2, ".", ",")
        );
        $("#add_to_cart_popup .period").text(lastPeriod);

        $.ajax({
            url: form.attr("action"),
            type: form.attr("method"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response, textStatus, jqXHR) {
                if (response.success) {
                    refreshDonatePageCart(response);
                    let item = $(form).closest(".item");
                    item.remove();
                }else if (!response.success && response.error === 'big_monthly_donate') {
                    alert(3)
                    Swal.fire({
                        html: '<h5 style="padding: 20px 0">For donations of this value <br> please contact our team on 0121 446 568</h5>',
                        width: '40em',
                        confirmButtonText: 'Ok'
                    })
                }
            },
            error: function (response) {
                toastr.error("Unknown error ", "Error");
            }
        });
    }

    function number_format(
        number,
        decimals = 0,
        dec_point = ".",
        thousands_sep = ","
    ) {
        let sign = number < 0 ? "-" : "";

        let s_number =
            Math.abs(parseInt((number = (+number || 0).toFixed(decimals)))) +
            "";
        let len = s_number.length;
        let tchunk = len > 3 ? len % 3 : 0;

        let ch_first = tchunk ? s_number.substr(0, tchunk) + thousands_sep : "";
        let ch_rest = s_number
            .substr(tchunk)
            .replace(/(\d\d\d)(?=\d)/g, "$1" + thousands_sep);
        let ch_last = decimals
            ? dec_point +
            (Math.abs(number) - s_number).toFixed(decimals).slice(2)
            : "";

        return sign + ch_first + ch_rest + ch_last;
    }

    refreshRelatedProjects();

    function refreshRelatedProjects() {
        let projects = $(".project");
        let projectsChecked = $(".add-width");
        let projectsCheckedMobile = $(".add");
        let arrProjectsId = [];

        projects.each(function () {
            arrProjectsId.push(parseInt($(this).val()));
        });

        projectsChecked.each(function () {
            let id = $(this).data("id");
            if ($.inArray(parseInt(id), arrProjectsId) == -1) {
                removeCheckedToProject($(this));
            } else {
                addCheckedToProject($(this));
            }
        });

        projectsCheckedMobile.each(function () {
            let id = $(this).data("id");
            let elDescr = $(this).closest(".descr");
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
        let descrEl = element.closest(".descr");
        if (descrEl.length) {
            $(descrEl).addClass("bg-btn-red");
            $(descrEl)
                .find("i")
                .addClass("moon-icons-check");
            $(descrEl)
                .find("i")
                .removeClass("moon-icons-plus");
        }
    }

    function removeCheckedToProjectMobile(element) {
        let descrEl = element.closest(".descr");
        if (descrEl.length) {
            $(descrEl).removeClass("bg-btn-red");
            $(descrEl)
                .find("i")
                .removeClass("moon-icons-check");
            $(descrEl)
                .find("i")
                .addClass("moon-icons-plus");
        }
    }

    //~~~~~~~~~~~~~~~~~~ Add and Clear project from 'checked' ~~~~~~~~~~~~~~~~~~~~
    function removeCheckedToProject(element) {
        if (!element.hasClass("d-none")) {
            const elItem = element.closest(".item");
            element.addClass("d-none");
            $(elItem)
                .find(".descr")
                .removeClass("bg-btn-red");
            $(elItem)
                .find(".add")
                .removeClass("d-none");
        }
    }

    function addCheckedToProject(element) {
        if (element.hasClass("d-none")) {
            const elItem = element.closest(".item");
            element.removeClass("d-none");
            $(elItem)
                .find(".descr")
                .addClass("bg-btn-red");
            $(elItem)
                .find(".add")
                .addClass("d-none");
        }
    }

    function showCartPopup() {
        $("#add_to_cart_popup").toggleClass('show-up');
        setTimeout(() => {
            $("#add_to_cart_popup").toggleClass('show-up');
            $("#add_to_cart_popup").toggleClass('show-out');
        }, 5000)
    }

    $(document).on("click", "#cartModal a.btn_checkout", function (e) {
        $("#cartModal").modal("hide");
    });

    $(document).on("click", "#cartModal .btn-remove", function (e) {
        e.preventDefault();
        var form = $(this).closest("form");

        //form.submit()
        sendFormAndRefreshCard(form);
    });

    $(document).on("click", "#donate-page-cart .btn-remove", function (e) {
        e.preventDefault();
        let form = $(this).closest("form");

        removeItemFromDonatePageCart(form);
    });

    $(document).on("click", "#clear_all_btn", function (e) {
        e.preventDefault();
        var form = $(this).closest("form");

        //form.submit()
        sendFormAndRefreshCard(form);
    });

    $(document).on("click", ".about-donation .btn-remove", function (e) {
        e.preventDefault();
        var form = $(this).closest("form");

        //form.submit()
        sendFormAndRefreshCard(form);
    });

    $(document).on("click", "[donate-btn]", function (e) {
        e.preventDefault();

        let form = $(this).closest("form");
        let amount = form.find('input[name="amount"]').val();

        if (amount < 5) {
            //toastr.warning('Sorry, your donation amount must be at least £5')
            $(".modal-at-least-5").modal("show");
            return;
        }

        //form.submit();
        sendFormAndRefreshCard(form, true);
    });

    $('.basket').first().on('click', openCart);
    $('#cartBackdrop').on('click', hideCart);
    $('.cart-close').on('click', hideCart);
});

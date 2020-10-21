$(function() {

     $('.open-head-menu').click(function (e) {
         e.preventDefault();
         $('.header-menu').addClass('open')
     })

     $('.header-menu .close-menu').click(function (e) {
         e.preventDefault();
         $('.header-menu').removeClass('open')
     })

     $("input[type='number']").inputSpinner()



    $('#cartModal').on('hide.bs.modal', function (e) {
        $('header .basket').removeClass('open')
    })
    $('#cartModal').on('show.bs.modal', function (e) {
        $('header .basket').addClass('open')
    })


    $('.donate-today-card .list .item').on('click', function () {
        $('.donate-today-card .list .item').removeClass('active');
        var $this = $(this)
        setTimeout(function () {
            $this.addClass('active');
        }, 100)
    })

    $('.calculator .title .toggle-title').on('click', function () {
        $(this).toggleClass('open');
        $('.calculator .title .bottom').toggleClass('open');
    })


} );


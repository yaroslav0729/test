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


} );
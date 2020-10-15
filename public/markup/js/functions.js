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


} );


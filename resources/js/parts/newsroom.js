$(function () {

    $(document).on('click', '.newsroom-tabs .nav-link', function () {
        $('.newsroom-tabs .nav-link').removeClass('active')
        $(this).addClass('active')    
    })
})
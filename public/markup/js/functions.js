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


    $('.our-work-term .actions a').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        var id  = $(this).attr('data-target')
        $('.our-work-term .actions .d-none').removeClass('d-none');
        $('.our-work-term .box, .our-work-term .img-video, .our-work-term .bg').addClass('d-none');


        // our-work-term-1
        // our-work-term-1-video
        // our-work-term-5-bg

        setTimeout(function () {
            $this.parent().addClass('d-none')
            $('.our-work-term #our-work-term-'+id).removeClass('d-none');
            $('.our-work-term #our-work-term-'+id+'-bg').removeClass('d-none');
            $('.our-work-term #our-work-term-'+id+'-video').removeClass('d-none');
        }, 0)
    })



    $(".foodpack-range").ionRangeSlider({
        grid: true,
        min: 1,
        max: 20,
        from: 1,
        step: 1,
    });

} );


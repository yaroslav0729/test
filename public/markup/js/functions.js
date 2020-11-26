$(function() {

     $('.open-head-menu').click(function (e) {
         e.preventDefault();
         $('.header-menu').addClass('open')
     })

     $('.header-menu .close-menu').click(function (e) {
         e.preventDefault();
         $('.header-menu').removeClass('open')
         if ($('body').hasClass('mobile-template')) {
             $('.header-menu').removeClass('dark-theme')
             $('.header-menu .level-*').hide();
             $('.header-menu .level-0').show();
             $('.header-menu .top .back').hide();
             $('.header-menu').attr('level', '0')
         }
     })

    $('.mobile-template .header-menu .back').on('click', function (e) {
        e.preventDefault();
        if ($('.header-menu').attr('level') == '1') {
            $('.header-menu').removeClass('dark-theme')
            $('.header-menu .level-0').show();
            $('.header-menu .level-1').hide();
            $('.header-menu .level-2').hide();
            $('.header-menu .level-3').hide();
            $('.header-menu .top .back').hide();
            $('.header-menu').attr('level', '0')
        }
        if ($('.header-menu').attr('level') == '2') {
            $('.header-menu').addClass('dark-theme')
            $('.header-menu .level-0').hide();
            $('.header-menu .level-1').show();
            $('.header-menu .level-2').hide();
            $('.header-menu .level-3').hide();
            $('.header-menu').attr('level', '1')
        }
        if ($('.header-menu').attr('level') == '3') {
            $('.header-menu').removeClass('dark-theme')
            $('.header-menu .level-0').hide();
            $('.header-menu .level-1').hide();
            $('.header-menu .level-2').show();
            $('.header-menu .level-3').hide();
            $('.header-menu').attr('level', '2')
        }
    })

     $('.mobile-template .header-menu .open-submenu').on('click', function (e) {
         e.preventDefault();
         var $target = $(this).attr('data-target')
         $('.header-menu .level-'+$target).show();
         if ($target == 1) {
             $('.header-menu').addClass('dark-theme')
             $('.header-menu .level-0').hide();
             $('.header-menu .top .back').show();
             $('.header-menu').attr('level', '1')
         }
         if ($target == 2) {
             $('.header-menu').removeClass('dark-theme')
             $('.header-menu .level-1').hide();
             $('.header-menu').attr('level', '2')
         }
         if ($target == 3) {
             $('.header-menu').addClass('dark-theme')
             $('.header-menu .level-2').hide();
             $('.header-menu').attr('level', '3')
         }
     })

    $('.mobile-template .toggle-menu').on('click', function (e) {
        $('.mobile-template .toggle-menu').next().toggle();
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
    $('.calculator .title .bottom .toggle-title').on('click', function () {
        $('.calculator .title .top .toggle-title').removeClass('open');
        $('.calculator .title .bottom').removeClass('open');

    })


    $('.our-work-term .actions a').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        var id  = $(this).attr('data-target')
        $('.our-work-term .actions .d-none').removeClass('d-none');
        $('.our-work-term .box, .our-work-term .img-video, .our-work-term .bg').addClass('d-none');

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


    $('footer .menu > li > a').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).parent().toggleClass('open');
    })

} );


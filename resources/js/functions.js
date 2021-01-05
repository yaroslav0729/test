$(function () {

    $(document).on('click', '.donate-today-card .list .item', function () {
        $('.donate-today-card .list .item').removeClass('active');

        console.log('click')

        var $this = $(this)
        setTimeout(function () {
            $this.addClass('active');
        }, 100)
    })

});
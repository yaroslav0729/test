$(function () {

    $(document).on('click', '.newsroom-tabs .nav-link', function () {
        $('.newsroom-tabs .nav-link').removeClass('active')
        $(this).addClass('active')
        
        $('.newsroom_tab_trending').addClass('d-none')
        $('.newsroom_tab_news').addClass('d-none')
        $('.newsroom_tab_press').addClass('d-none')
        $('.newsroom_tab_cinema').addClass('d-none')

        let activeClass = $(this).data('active')
        $('.' + activeClass).removeClass('d-none')

        let textSpan = ''
        let textI = ''

        switch (activeClass) {
            case 'newsroom_tab_trending' : {
                textSpan = 'Trending'
                textI = 'Trending articles'
                break;
            }
            case 'newsroom_tab_news' : {
                textSpan = 'News'
                textI = 'News articles'
                break;
            }
            case 'newsroom_tab_press' : {
                textSpan = 'Press'
                textI = 'Press'
                break;
            }
            case 'newsroom_tab_cinema' : {
                textSpan = 'Cinema'
                textI = 'IH Cinema'
                break;
            }
        }

        $('#newsroom_title_span').text(textSpan)
        $('#newsroom_title_i').text(textI)
    })


})
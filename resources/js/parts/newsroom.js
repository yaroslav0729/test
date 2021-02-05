$(function () {

    setupCurrentTab()

    function setupCurrentTab() {

        $('.newsroom_tab_trending').addClass('d-none')
        $('.newsroom_tab_news').addClass('d-none')
        $('.newsroom_tab_press').addClass('d-none')
        $('.newsroom_tab_cinema').addClass('d-none')
        
        let activeClass = $('.newsroom-tabs .nav-link.active').data('active')
        $('.' + activeClass).removeClass('d-none')
    }

    $(document).on('click', '.newsroom-tabs .nav-link', function () {
        $('.newsroom-tabs .nav-link').removeClass('active')
        $(this).addClass('active')
        
        $('.newsroom_tab_trending').addClass('d-none')
        $('.newsroom_tab_news').addClass('d-none')
        $('.newsroom_tab_press').addClass('d-none')
        $('.newsroom_tab_cinema').addClass('d-none')

        let activeClass = $(this).data('active')
        $('.' + activeClass).removeClass('d-none')
    })

    //~~~~~~~~~~~~~~~~~~~~~~~ Trending articles module ~~~~~~~~~~~~~~~~~~~~~~~

    $(document).on('click', '[newsroom-articles] .pagination a', function (e) {

        return

        e.preventDefault()

        let path = $(this).attr('href');

        const url = new URL(path);
        let page = url.searchParams.get('trending_articles')
        let data = {}
        let apiUrl = '/api/get_articles/' + page

        $.get(apiUrl, data, refreshTrendingArticles, 'json');

    });

    function refreshTrendingArticles(response) {

        let newBody = $('[newsroom-articles-body]', response.html)
        $('[newsroom-articles-body]').html(newBody.html())

        let newPagination = $('[newsroom-articles-pagination]', response.html)
        $('[newsroom-articles-pagination]').html(newPagination.html())
    }

})
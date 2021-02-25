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
        e.preventDefault()

        let path = $(this).attr('href');
        getNewBody(path);
    });

    function getNewBody(path) {

        const url = new URL(path);

        let page1 = url.searchParams.get('trending_articles')
        let page2 = url.searchParams.get('news_articles')
        let page3 = url.searchParams.get('press_articles')

        let category = ''

        if (page1 !== null) {
            page = page1;
            category = 'trending_articles'
        } else if (page2 !== null) {
            page = page2;
            category = 'news_articles'
        } else if (page3 !== null) {
            page = page3;
            category = 'press_articles'
        }

        let data = {}

        $('.newsroom-tab-by-sort').each(function () {
           if (!$(this).hasClass('d-none')) {
               data['dataSort'] = $(this).find('.btn-white').attr('data-sort');
           }
        });

        let apiUrl = '/api/get_articles/' + category + '/' + page
        $.get(apiUrl, data, refreshTrendingArticles, 'json');
    }

    function refreshTrendingArticles(response) {

        let tab;

        switch (response.category) {
            case 'trending_articles': {
                tab = $('.newsroom_tab_trending')
                break;
            }
            case 'news_articles': {
                tab = $('.newsroom_tab_news')
                break;
            }
            case 'press_articles': {
                tab = $('.newsroom_tab_press')
                break;
            }
        }

        let newBody = $('[newsroom-articles-body]', response.html);
        $(tab).find('[newsroom-articles-body]').html(newBody.html())

        let newPagination = $('[newsroom-articles-pagination]', response.html)
        $(tab).find('[newsroom-articles-pagination]').html(newPagination.html())
    }

    //~~~~~~~~~~~~~~~~~~~~~~ Filters on Newsroom page ~~~~~~~~~~~~~~~~
    $(document).on('click', '.btn-newsroom', function () {
        let link = $('[newsroom-articles] .pagination a').eq(1);
        let path = $(link).attr('href');

        changeStatusBtn(this);
        getNewBody(path);

        function changeStatusBtn(element) {
            if ($(element).hasClass('btn-white')) {
                const secondChild =  $(element).closest('div').find('.btn-primary-dark');

                $(element).removeClass('btn-white');
                $(element).addClass('btn-primary-dark');

                $(secondChild).addClass('btn-white');
                $(secondChild).removeClass('btn-primary-dark');
            }
        }
    });
})

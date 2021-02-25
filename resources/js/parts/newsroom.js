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

    $(document).on('click', '.newsroom-tabs .nav-link', function (e) {
        e.preventDefault();
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

    function getNewBody(path, page = 0) {

        const url = new URL(path);

        let page1 = url.searchParams.get('trending_articles')
        let page2 = url.searchParams.get('news_articles')
        let page3 = url.searchParams.get('press_articles')

        let category = ''

        if (page1 !== null) {
            page = (page === 0) ? page1 : 1;
            category = 'trending_articles'
        } else if (page2 !== null) {
            page = (page === 0) ? page2 : 1;
            category = 'news_articles'
        } else if (page3 !== null) {
            page = (page === 0) ? page3 : 1;
            category = 'press_articles'
        }
        let data = {}

        $('.newsroom-tab-by-sort').each(function () {
            if (!$(this).hasClass('d-none')) {
                data['dataSort'] = $(this).find('.btn-active').attr('data-sort');
            }
        });

        let apiUrl = '/api/get_articles/' + category + '/' + page;
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
        let section = (this).closest('.newsroom-tab-by-sort');
        let link = $(section).find('[newsroom-articles] .pagination a').eq(1);
        let path = $(link).attr('href');

        if ($(this).hasClass('btn-primary-dark')) {
            changeStatusBtn(this);
            getNewBody(path, 1);
        }

        function changeStatusBtn(element) {
            let secondChild;
            let className;
            const parent = $(element).closest('.newsroom-tab-by-sort');

            if ($(parent).hasClass('newsroom-tab-white')) {
                className = 'btn-white';
                secondChild = $(element).closest('.newsroom-list').find('.btn-white');
            } else {
                className = 'btn-light-gray';
                secondChild = $(element).closest('div').find('.btn-light-gray');
            }

            $(element).removeClass('btn-primary-dark');
            $(element).addClass(className);
            $(element).toggleClass('btn-active');

            $(secondChild).removeClass(className);
            $(secondChild).addClass('btn-primary-dark');
            $(secondChild).toggleClass('btn-active');

        }
    });
})

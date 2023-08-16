<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use \App\Models\Page;
use \App\Models\Template;

class ArticlesHelper
{
    const ARTICLES_PER_PAGE = 8;

    const TRENDING_PAGINATOR = 'trending_articles';
    const NEWS_PAGINATOR = 'news_articles';
    const PRESS_PAGINATOR = 'press_articles';

    public static function getNewsroomTrendingArticles(int $page = 1, string $sortParam = 'date')
    {
        if ($page < 1) {
            $page = 1;
        }

        $pages = Page::whereHas('pageInstances', function (Builder $query) {
            $query->where('template', Template::COMMON_CONTENT_PAGE)
                    ->where('slug', 'like', '%' . 'media-centre/news/' . '%')
                    ->orderBy('title', 'asc')
            ;

        })
        ->published();
        if ($sortParam === 'date') {
            $pages->orderBy('published_at', 'desc');
        }
        $pages = $pages->paginate(self::ARTICLES_PER_PAGE, ['*'], self::TRENDING_PAGINATOR, $page);

        return $pages;
    }

    public static function getNewsroomNewsArticles(int $page = 1, string $sortParam = 'date')
    {
        if ($page < 1) {
            $page = 1;
        }

        $pages = Page::whereHas('pageInstances', function (Builder $query) {
            $query->where('template', Template::COMMON_CONTENT_PAGE)
                    ->where('slug', 'like', '%' . 'media-centre/news/' . '%')
                    ->orderBy('title', 'asc');

        })
        ->published();

        if ($sortParam === 'date') {
            $pages->orderBy('published_at', 'desc');
        }
        $pages = $pages->paginate(self::ARTICLES_PER_PAGE, ['*'], self::NEWS_PAGINATOR, $page);

        return $pages;
    }

    public static function getNewsroomPressArticles(int $page = 1, string $sortParam = 'date')
    {
        if ($page < 1) {
            $page = 1;
        }

        $pages = Page::whereHas('pageInstances', function (Builder $query) {
            $query->where('template', Template::COMMON_CONTENT_PAGE)
                    ->where('slug', 'like', '%' . 'media-centre/press-releases/' . '%')
                    ->orderBy('title', 'asc');

        })
        ->published();
        if ($sortParam === 'date') {
            $pages->orderBy('published_at', 'desc');
        }
        $pages = $pages->paginate(self::ARTICLES_PER_PAGE, ['*'], self::PRESS_PAGINATOR, $page);

        return $pages;
    }

    public static function getMinRead($pageInstance)
    {
        $parameters = $pageInstance->parameters;
        $html = '';

        if (isset($parameters['main_html'])) {
            $html = $parameters['main_html'];
        }

        $html = strip_tags($html);

        $minRead = round(strlen($html)/1000, 0, PHP_ROUND_HALF_UP);
        if ((int)$minRead === 0) {
            $minRead = 1;
        }

        return $minRead;
    }

    public static function getPopularTopics()
    {
        $pages = Page::whereHas('pageInstances', function (Builder $query) {
            $query->where('template', Template::COMMON_CONTENT_PAGE)
                    ->where('slug', 'like', '%' . 'media-centre/news/' . '%')
                    ->where('preview_img', '<>', '');

        })
        ->published()
        ->limit(3)
        ->orderBy('created_at', 'desc')
        ->get();

        return $pages;
    }

}

<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;
use \App\Models\Page;
use \App\Models\Template;

class ArticlesHelper
{
    const TRENDING_ARTICLES_PER_PAGE = 4;

    public static function getNewsroomArticles(int $page = 1)
    {
        if ($page < 1) {
            $page = 1;
        }

        $pages = Page::whereHas('pageInstances', function (Builder $query) {
            $query->where('template', Template::COMMON_CONTENT_PAGE)
                    ->where('slug', 'like', '%' . 'media-centre/news/' . '%');

        })
        ->published()
        ->orderBy('created_at', 'desc')
        ->paginate(self::TRENDING_ARTICLES_PER_PAGE, ['*'], 'trending_articles', $page);

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

}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ArticlesHelper;

class ArticleController extends Controller
{
    public function getArticles($category, $page, Request $request)
    {
        $newsroomPath = \App\Models\Page::getNewsroomPage() ? \App\Models\Page::getNewsroomPage()->slug : '';
        $articles = [];
        $sortParam = $request->dataSort;

        switch ($category) {
            case ArticlesHelper::TRENDING_PAGINATOR: {
                $articles = ArticlesHelper::getNewsroomTrendingArticles($page, $sortParam);
                $articles->withPath(url($newsroomPath));
                break;
            }
            case ArticlesHelper::NEWS_PAGINATOR: {
                $articles = ArticlesHelper::getNewsroomNewsArticles($page);
                $articles->withPath(url($newsroomPath));
                break;
            }
            case ArticlesHelper::PRESS_PAGINATOR: {
                $articles = ArticlesHelper::getNewsroomPressArticles($page);
                $articles->withPath(url($newsroomPath));
                break;
            }
        }

        $html = view('modules.presentation.newsroom_articles', [
            'articles' => $articles,
            'titleSpan' => 'Trending',
            'titleI' => 'Trending articles'
        ])->render();

        return response()->json([
            'message' => 'Success',
            'success' => true,
            'page' => $page,
            'category' => $category,
            'html' => $html
        ]);
    }
}

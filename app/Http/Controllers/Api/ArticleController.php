<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function getTrendingArticles($page)
    {
        $html = view('modules.presentation.trending_articles', [
            'selectedPage' => $page
        ])->render();

        return response()->json([
            'message' => 'Success',
            'success' => true,
            'page' => $page,
            'html' => $html
        ]);  
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function getArticles($page)
    {
        $html = view('modules.presentation.newsroom_articles', [
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

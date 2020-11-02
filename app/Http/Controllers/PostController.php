<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostContainer;
use Illuminate\Database\Eloquent\Builder;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.home');
    }

    public function showFromSlug($slug)
    {
        $post = Post::where('slug', $slug)
                ->where('actual', true)
                ->whereHas('container', function(Builder $query) {
                    $query->where('status', PostContainer::POST_STATUS_PUBLICHED);   
                })
                ->firstOrFail();

        return view('post', compact('post'));
    }
}

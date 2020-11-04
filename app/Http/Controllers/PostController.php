<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostContainer;
use Illuminate\Database\Eloquent\Builder;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

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

        SEOMeta::setTitle($post->title);
        SEOMeta::setDescription($post->description);
        SEOMeta::setCanonical(url()->current());

        OpenGraph::setTitle($post->title);
        OpenGraph::setDescription($post->description);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'articles');

        return view('post', compact('post'));
    }
}

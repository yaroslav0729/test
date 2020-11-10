<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\PageInstance;
use Illuminate\Database\Eloquent\Builder;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('pages.home');

        $indexPage = Page::index()->first();
        $pageInstance = $indexPage->actual_page_instance; 

        SEOMeta::setTitle($pageInstance->title);
        SEOMeta::setDescription($pageInstance->description);
        SEOMeta::setCanonical(url()->current());

        OpenGraph::setTitle($pageInstance->title);
        OpenGraph::setDescription($pageInstance->description);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'articles');

        $html = $pageInstance->renderTemplate()->render();
        $html = \App\Models\Widget::replaceMonikers($html);

        return view('page', compact('html'));
    }

    public function showFromSlug($slug)
    {
        $pageInstance = PageInstance::where('slug', $slug)
                ->where('actual', true)
                ->whereHas('page', function(Builder $query) {
                    $query->where('status', Page::PAGE_STATUS_PUBLICHED);   
                })
                ->firstOrFail();

        SEOMeta::setTitle($pageInstance->title);
        SEOMeta::setDescription($pageInstance->description);
        SEOMeta::setCanonical(url()->current());

        OpenGraph::setTitle($pageInstance->title);
        OpenGraph::setDescription($pageInstance->description);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'articles');

        $html = $pageInstance->renderTemplate()->render();
        $html = \App\Models\Widget::replaceMonikers($html);
 
        return view('page', compact('html'));
    }
}

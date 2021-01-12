<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PageInstance;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Database\Eloquent\Builder;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        if ($slug === 'index') {
            return redirect('/');
        }

        $pageInstance = PageInstance::where('slug', $slug)
            ->where('actual', true)
            ->whereHas('page', function(Builder $queryPage) {
                $queryPage->published();
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

        $headerTemplate = 'parts.header_short';

        if ($pageInstance->template === \App\Models\Template::NEWSROOM_PAGE) {
            $headerTemplate = 'parts.header_newsroom';
        }

        return view('page', compact('html', 'headerTemplate'));
    }
}

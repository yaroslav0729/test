<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Page;
use App\Models\PageInstance;
use App\Models\Redirect;
use App\Models\Template;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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

    public function showFromSlug($slug, Request $request)
    {
        $slug = \App\Helpers\StrHelper::deleteTrailingSlash($slug);

        if ($slug === 'index') {
            return redirect('/');
        }

        if (Redirect::slugHasRedirect($slug)) {
            return Redirect::redirectFromSlug($slug);
        }

        $pageInstance = PageInstance::where('slug', $slug)
            ->where('actual', true)
            ->whereHas('page', function (Builder $queryPage) {
                $queryPage->published();
            })
            ->firstOrFail();

        if ($request->ajax() && $pageInstance->template === Template::EVENTS_PAGE) {
            $events = Event::searchByParam($request->all());

            $html = view('templates.presentation.parts.events_filter', ['events' => $events]);
            $htmlEstates = $html->render();

            return response()->json([
                'html' => $htmlEstates,
                'status' => 'success',
            ]);
        }

        SEOMeta::setTitle($pageInstance->title);
        SEOMeta::setDescription($pageInstance->description);
        SEOMeta::setCanonical(url()->current());

        OpenGraph::setTitle($pageInstance->title);
        OpenGraph::setDescription($pageInstance->description);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'articles');

        $html = $pageInstance->renderTemplate()->render();
        $html = \App\Models\Widget::replaceMonikers($html);

        
        $headerColorClass = 'blue';

        if ($pageInstance->template === \App\Models\Template::MISSION_POSSIBLE)  {
            $headerColorClass = 'white';
        } 

        return view('page', compact('html', 'headerColorClass'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\Page;
use App\Models\PageInstance;
use App\Models\Redirect;
use App\Models\Template;
use App\Models\TempStoreDonationData;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Traits\IcharmData;
use DB;

class PageController extends Controller
{
    use IcharmData;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $indexPage = Page::published()->index()->first();
        $pageInstance = $indexPage->actual_page_instance;
        if(isset($pageInstance['title']))$pageInstance->title="Islamic Help";
        if(isset($pageInstance['description']))$pageInstance->description="Islamic Help";

        SEOMeta::setTitle($pageInstance->title);
        SEOMeta::setDescription($pageInstance->description);
        SEOMeta::setCanonical(url()->current());

        OpenGraph::setTitle($pageInstance->title);
        OpenGraph::setDescription($pageInstance->description);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'articles');

        $html = $pageInstance->renderTemplate()->render();
        $html = \App\Models\Widget::replaceMonikers($html);
        $configTemplate = Template::getConfigureTemplate($pageInstance->template);
        $template = strtolower(preg_replace('/\s+/', '-', Template::getLabel($pageInstance->template)));

        return view('page', compact('html', 'configTemplate', 'template'));
    }

    public function showFromSlug($slug, Request $request)
    {
        $slug = \App\Helpers\StrHelper::deleteTrailingSlash($slug);

        if ($slug === 'index') {
            return redirect('/');
        }
        // if ($slug === 'thank-you-page') {
        //     $orderId = $request->order;
        //     $donationData = TempStoreDonationData::where(['order_id' => $orderId])->get(['donation_data', 'id'])->toArray();
        //     if (!empty($donationData)) {
        //         foreach ($donationData as $key => $donation) {
        //             $this->addDonationToIcharm(unserialize($donation['donation_data']));
        //             TempStoreDonationData::where('id', $donation->id)->update(['sent_at' => now()]);
        //         }
        //     }
        // }

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
        $configTemplate = Template::getConfigureTemplate($pageInstance->template);
        $template = strtolower(preg_replace('/\s+/', '-', Template::getLabel($pageInstance->template)));

        return view('page', compact('html', 'configTemplate', 'template'));
    }
}

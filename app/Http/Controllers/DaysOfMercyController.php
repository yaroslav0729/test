<?php

namespace App\Http\Controllers;

use App\Models\MyTenNghts;
use App\Models\Page;
use App\Models\Template;
use App\Services\DaysOfMercyService;
use Exception;
use Illuminate\Http\Request;
use Stripe\Exception\ApiErrorException;

class DaysOfMercyController extends Controller
{
    private DaysOfMercyService $daysOfMercyService;

    public function __construct(DaysOfMercyService $daysOfMercyService)
    {
        $this->daysOfMercyService = $daysOfMercyService;
    }

    public function index()
    {
        return view('pages.days-of-mercy-payment');
    }

    /**
     * @throws Exception
     */
    public function store(Request $request)
    {
        $url = $this->daysOfMercyService->createDonates($request->all(), $request->ip());

        return redirect()->away($url);
    }

    /**
     * @throws ApiErrorException
     */
    public function process(Request $request)
    {
        $this->daysOfMercyService->processSubcription($request->order);

        $thanksUrl = Page::getSinglePageUrl(Template::THANK_YOU_SUBSCRIPTION_PAGE);
        $url = url($thanksUrl);

        return redirect()->to($url);
    }

    public function unsubscribe()
    {
        MyTenNights::where('user_id', auth()->id())->delete();

        return redirect()->back();
    }

    public function portal()
    {
        if (!empty(auth()->user()->stripe_customer_id)) {
            return redirect()->away($this->getStripePortalUrlByCustomerId(auth()->user()->stripe_customer_id));
        }

        abort(403);
    }
}

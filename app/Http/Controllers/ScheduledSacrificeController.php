<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignCategory;
use App\Models\Donation;
use App\Models\Order;
use App\Models\Page;
use App\Models\PageInstance;
use App\Models\Template;
use App\Services\FoodPackQurbaniService;
use App\Services\StripeService;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduledSacrificeController extends Controller
{
    private StripeService $stripeService;
    private FoodPackQurbaniService $foodPackService;

    public function __construct(StripeService $stripeService, FoodPackQurbaniService $foodPackService)
    {
        $this->stripeService = $stripeService;
        $this->foodPackService = $foodPackService;
    }

    public function index()
    {
        $pageInstance = PageInstance::where('slug', 'qurbani-2024')->where('actual', true)->firstOrFail();
        $amount = $pageInstance->parameters['amount'];
        $campaignIds = [];
        foreach ($amount as $item) {
            $campaignIds = array_merge($campaignIds, $item['campaigns']);
        }
        $campaigns = Campaign::whereIn('id', $campaignIds)->get();
        $campaignsCategories = \App\Models\Project::getProjectCampaignsCateg($pageInstance);
        $campaignsCountries = \App\Models\Project::getProjectCampaignsCountries($pageInstance);

        $startDate = Carbon::today();
        $endDate = Carbon::createFromDate(null, 7, 4)->endOfDay();
        $availableDates = [];

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $availableDates[$date->format('jS \\of F')] = $date->hour(10)->timestamp;
        }

        $pricesList = $this->foodPackService->getList();
        $amount = collect($amount);

        $qurbaniPage = PageInstance::where('slug', 'qurbani-2024')->where('actual', true)->first();
        $parameters = $qurbaniPage->parameters;

        SEOMeta::setTitle('Schedule Your Sacrifice | Qurbani with Islamic Help');
        SEOMeta::setDescription('Give Qurbani this year using our Schedule Your Sacrifice tool. Choose from over 12 countries worldwide.');
        SEOMeta::setCanonical(url()->current());

        OpenGraph::setTitle('Schedule Your Sacrifice | Qurbani with Islamic Help');
        OpenGraph::setDescription('Give Qurbani this year using our Schedule Your Sacrifice tool. Choose from over 12 countries worldwide.');
        OpenGraph::setUrl(url()->current());

        return view('pages.scheduled-qurbani',
            compact('amount', 'campaignsCategories', 'campaignsCountries', 'availableDates', 'pricesList', 'campaigns', 'parameters'));
    }

    public function schedule(Request $request)
    {
        $order = Order::create($request->except(['prices', 'schedule']));

        $donationsData = $request->prices;
        $donations = [];

        foreach ($donationsData as $donationData) {
            $donations[] = $this->prepareDonation($donationData, $order, $request->ip());
        }

        $scheduleDate = Carbon::createFromTimestamp($request->schedule)->startOfDay();
        $nowDate = Carbon::now();
        $payLink = '';
        $thanksUrl = Page::getSinglePageUrl(Template::THANK_YOU_DONATE_PAGE);
        $url = url($thanksUrl . '?order={CHECKOUT_SESSION_ID}');
        if ($scheduleDate->eq($nowDate->startOfDay())) {
            $items = [];
            foreach ($donations as $donation) {
                $items[] = [
                    'price_data' => [
                        'currency' => 'gbp',
                        'product_data' => [
                            'name' => $donation->campaign->name,
                        ],
                        'unit_amount' => $donation->value * 100,
                    ],
                    'quantity' => 1,
                ];
            }
            $session = \Stripe\Checkout\Session::create([
                'line_items' => [$items],
                'mode' => 'payment',
                'success_url' => $url,
                'cancel_url' => route('index'),
                'customer_email' => $order->email,
            ]);
            $payLink = $session->url;
            $order->order_id = $session->id;
        } else {
            $customer = $this->stripeService->processCustomer($request->except(['prices', 'schedule']));
            $session = \Stripe\Checkout\Session::create([
                'mode' => 'setup',
                'success_url' => $url,
                'cancel_url' => route('index'),
                'customer' => $customer->id,
                'metadata' => [
                    'scheduled_qurbani' => true,
                    'order_id' => $order->id,
                    'billing_anchor' => $request->schedule,
                ],
                'payment_method_types' => [
                    'card',
                    'bacs_debit',
                ],
            ]);
            $payLink = $session->url;
            $order->order_id = $session->id;
            $order->pay_with = 'stripe';
        }
        $order->save();

        return response()->json([
            'payment_link' => $payLink,
        ]);
    }

    public function prepareDonation(array $donationData, Order $order, string $ip)
    {
        $categoryId = null;
        if (isset($donationData['campaignCategory'])) {
            $campaignCategory = CampaignCategory::where('name', $donationData['campaignCategory'])->first();
            $categoryId = $campaignCategory->id;
        }

        return Donation::create([
            'value' => (int)$donationData['amount'],
            'order_id' => $order->id,
            'type' => $donationData['period'],
            'currency' => 'GBP',
            'campaign_id' => (int)$donationData['campaignId'],
            'campaign_category' => $categoryId,
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'email' => $order->email,
            'qurbani_name' => $donationData['name'],
            'commission' => null,
            'ip' => $ip,
        ]);
    }
}

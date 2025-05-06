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
use Illuminate\Support\Facades\Log;

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
        $endDate = Carbon::createFromDate(null, 6, 9)->endOfDay();
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
            $campaign = Campaign::find($donationData['campaignId']);
            $donations[] = $this->prepareDonation($donationData, $order, $request->ip(), $campaign, $request->schedule);
        }

        $payLink = '';
        $thanksUrl = Page::getSinglePageUrl(Template::THANK_YOU_DONATE_PAGE);
        $successUrl = url($thanksUrl . '?order={CHECKOUT_SESSION_ID}');
        $cancelUrl = route('index');

        \Stripe\Stripe::setApiKey(config('stripe.secret_key'));

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

        try {
            $session = \Stripe\Checkout\Session::create([
                'line_items' => $items,
                'mode' => 'payment',
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
                'customer_email' => $order->email,
                'metadata' => $this->stripeService->combineWithBaseMetadata([
                    'internal_order_id' => $order->id,
                    'scheduled_timestamp' => $request->schedule,
                ]),
            ]);

            $payLink = $session->url;
            $order->order_id = $session->id;
            $order->pay_with = 'stripe';
            $order->save();

        } catch (\Exception $e) {
            Log::error("Stripe Checkout Session creation failed for order {$order->id}: " . $e->getMessage());
            return response()->json([
                'error' => 'Could not initiate payment. Please try again later.',
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'payment_link' => $payLink,
        ]);
    }

    public function prepareDonation(array $donationData, Order $order, string $ip, Campaign $campaign, ?int $scheduledTimestamp = null)
    {
        $categoryId = null;
        if (isset($donationData['campaignCategory'])) {
            $campaignCategory = CampaignCategory::where('name', $donationData['campaignCategory'])->first();
            $categoryId = $campaignCategory ? $campaignCategory->id : null;
        }

        return Donation::create([
            'value' => (int)$donationData['amount'],
            'order_id' => $order->id,
            'type' => $donationData['period'] ?? Donation::TYPE_SINGLE,
            'currency' => 'GBP',
            'campaign_id' => $campaign->id,
            'campaign_category_id' => $categoryId,
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'email' => $order->email,
            'qurbani_name' => $campaign->name,
            'commission' => null,
            'status' => Donation::STATUS_SCHEDULED,
            'note' => $donationData['name'],
            'ip' => $ip,
        ]);
    }
}

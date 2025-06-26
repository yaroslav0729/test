<?php

namespace App\Http\Controllers;

use App\Helpers\SettingHelper;
use App\Http\Requests\OrderRequest;
use App\Models\Upsell;
use App\Services\BlackListService;
use App\Services\StripeService;
use Illuminate\Http\Request;
use App\Models\CampaignCategory;
use App\Models\CartItem;
use App\Models\CampaignPrice;
use App\Models\Campaign;
use App\Models\Country;
use App\Models\Donation;
use App\Models\Order;
use App\Models\Currency;
use App\Models\Page;
use App\Models\Template;
use App\Models\TempStoreDonationData;
use App\Services\BankAccountChecker;
use App\Services\GlobalPay;
use App\Services\Paypal;
use App\Traits\SendThankYouEmail;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use function Symfony\Component\Translation\t;

class CartController extends Controller
{
    use SendThankYouEmail;

    protected $bankChecker;
    private BlackListService $blackListService;
    private StripeService $stripeService;

    public function __construct(BankAccountChecker $bc, BlackListService $blackListService, StripeService $stripeService)
    {
        $this->bankChecker = $bc;
        $this->blackListService = $blackListService;
        $this->stripeService = $stripeService;
    }

    public function add(Request $request)
    {
        $categoryId = null;
        $amount = $request->amount;
        $campaignId = $request->campaigns;
        $projectId = $request->project_id;

        if (isset($request->categories)) {
            $category = CampaignCategory::where('name', $request->categories)->first();

            if (isset($category)) {
                $categoryId = $category->id;
            }
        }

        if (isset($request->period)) {
            $period = array_search($request->period, CampaignPrice::ALL_TYPES);
        } else {
            $period = CampaignPrice::TYPE_SINGLE;
        }

        if ($period == CampaignPrice::TYPE_MONTHLY && $amount > 2000) {
            return response()->json([
                'message' => 'Error',
                'success' => false,
                'error' => 'big_monthly_donate',
                'cart_html' => view('parts.modal_cart')->render(),
                'cart_donate' => view('modules.presentation.donation_page_cart')->render(),
                'sum' => CartItem::getCartSum(),
                'sum_for_view' => CartItem::roundCurrency(CartItem::getCartSum()),
                'commission' => StripeService::countCommission(CartItem::getCartSum()),
            ]);
        }


        $note = $request->note;

        $cartItem = CartItem::create([
            'amount' => $amount,
            'campaign_id' => $campaignId,
            'food_pack_id' => $request->get('food_pack_id'),
            'food_pack_qurbani_id' => $request->get('food_pack_qurbani_id'),
            'food_pack_qurbani_type_id' => $request->get('food_pack_qurbani_type_id'),
            'campaign_category_id' => $categoryId,
            'period' => $period,
            'note' => $note,
            'project_id' => $projectId,
            'goal' => $request->get('goal') ?? null,
            'upsell' => $request->get('upsell') ?? false,
        ]);

        $this->sessionCartPut($cartItem->cart_item_id);

        if (request()->ajax()) {
            return response()->json([
                'message' => 'Success message',
                'success' => true,
                'cart_html' => view('parts.modal_cart')->render(),
                'cart_donate' => view('modules.presentation.donation_page_cart')->render(),
                'sum' => CartItem::getCartSum(),
                'sum_for_view' => CartItem::roundCurrency(CartItem::getCartSum()),
                'commission' => StripeService::countCommission(CartItem::getCartSum()),
                'session' => session()->get('cart')
            ]);
        }

        return redirect()->back();
    }

    public function upsell()
    {
        $itemIds = session()->get('cart');

        $upsellItem = CartItem::whereIn('cart_item_id', $itemIds)->where('upsell', true)->first();
        $upsell = Upsell::first();

        if (!$upsellItem) {
            $upsellItem = CartItem::create([
                'amount' => $upsell->price,
                'period' => CampaignPrice::TYPE_SINGLE,
                'upsell' => true,
                'name' => $upsell->title,
            ]);

            $this->sessionCartPut($upsellItem->cart_item_id);
        } else {
            $this->sessionCartDelete($upsellItem->cart_item_id);
            $upsellItem->delete();
        }

        return response()->json([
            'message' => 'Success message',
            'success' => true,
            'cart_html' => view('parts.modal_cart')->render(),
            'cart_donate' => view('modules.presentation.donation_page_cart')->render(),
            'sum' => CartItem::getCartSum(),
            'sum_for_view' => CartItem::roundCurrency(CartItem::getCartSum()),
            'commission' => StripeService::countCommission(CartItem::getCartSum()),
            'session' => session()->get('cart')
        ]);
    }

    public function remove(Request $request, $itemId)
    {
        $item = CartItem::where('cart_item_id', $itemId)->firstOrFail();
        $deletedItems = $item->removeSameItems();

        foreach ($deletedItems as $delItem) {
            $this->sessionCartDelete($delItem);
        }

        $item->delete();
        $this->sessionCartDelete($itemId);

        if (request()->ajax()) {
            return response()->json([
                'message' => 'Success message',
                'success' => true,
                'cart_html' => view('parts.modal_cart')->render(),
                'cart_donate' => view('modules.presentation.donation_page_cart')->render(),
                'sum' => CartItem::getCartSum(),
                'sum_for_view' => CartItem::roundCurrency(CartItem::getCartSum()),
                'commission' => StripeService::countCommission(CartItem::getCartSum()),
            ]);
        }

        return redirect()->back();
    }

    public function clear()
    {
        $this->clearCart();

        if (request()->ajax()) {
            return response()->json([
                'message' => 'Success message',
                'success' => true,
                'cart_html' => view('parts.modal_cart')->render(),
                'cart_donate' => view('modules.presentation.donation_page_cart')->render(),
                'sum' => CartItem::getCartSum(),
                'sum_for_view' => CartItem::roundCurrency(CartItem::getCartSum()),
                'commission' => StripeService::countCommission(CartItem::getCartSum()),
            ]);
        }

        return redirect()->back();
    }

    protected function clearCart()
    {
        $itemIds = session()->get('cart');

        CartItem::whereIn('cart_item_id', $itemIds)->delete();

        session()->put('cart', []);
    }

    public function paymentForm()
    {
        return view('pages.payment');
    }

    public function checkAccount(Request $request)
    {
        [$valid, $message] = $this->bankChecker->isCardValid($request->account_number, $request->sort_code);
        if (!$valid) {
            return response()->json(['success' => false, 'error' => $message]);
        } else {
            return response()->json(['success' => true]);
        }
    }

    public function order(OrderRequest $request)
    {
        $cartIds = session()->get('cart');
        $country = Country::find(intval($request->get('country')));
        $cartItems = CartItem::whereIn('cart_item_id', $cartIds)->get();
        $orderData = $request->all();
        $orderData['country'] = $country ? $country->name : '';
        $order = Order::create($orderData);
        $monthlyItems = [];
        $singleItems = [];

        $totalDonations = $cartItems->count();
        if ($cartItems->where('period', 20)->sum('amount') > config('config.max_monthly_donate')) {
            return back()->with('error', "For donations of this value please contact our team on 0121 446 568.");
        }

        // Stripe-specific customer creation (skip for PayPal)
        $customer = null;
        if ($request->get('pay_method') !== 'paypal') {
            try {
                $customer = $this->stripeService->processCustomer([
                    'first_name' => $order->first_name,
                    'last_name' => $order->last_name,
                    'email' => $order->email,
                    'phone' => $order->phone,
                    'city' => $order->city,
                    'address_1' => $order->address_1,
                    'address_2' => $order->address_2,
                    'post_code' => $order->post_code,
                ]);
                $this->stripeService->processUser($orderData, $customer);

                if ($request->has('payment_method_id')) {
                    $this->stripeService->attachPaymentMethodToCustomer(
                        $request->payment_method_id,
                        $customer->id
                    );
                }
            } catch (\Exception $e) {
                Log::error('Stripe customer creation or payment method attachment failed: ' . $e->getMessage());
                return back()->with('error', 'Payment processing failed. Please try again.');
            }
        }

        foreach ($cartItems as $cartItem) {
            if ($cartItem->period == 20) {
                if ($this->blackListService->isBlackIp($request->ip())) {
                    return back()->with('error', "Sorry, your ip ({$request->ip()}) is blocked. Please contact our support.");
                }
            }

            $donation = Donation::create([
                'value' => $cartItem->amount,
                'order_id' => $order->id,
                'type' => $cartItem->period,
                'currency' => 'GBP',
                'campaign_id' => $cartItem->campaign_id,
                'food_pack_id' => $cartItem->food_pack_id,
                'food_pack_qurbani_id' => $cartItem->food_pack_qurbani_id,
                'food_pack_qurbani_type_id' => $cartItem->food_pack_qurbani_type_id,
                'campaign_category_id' => $cartItem->campaign_category_id,
                'user_id' => auth()->user() ? auth()->user()->id : null,
                'email' => $order->email,
                'commission' => $request->stripe_fee ? StripeService::countCommission(CartItem::getCartSum()) / $totalDonations : null,
                'note' => $request->get('notes_' . $cartItem->cart_item_id) ?? $cartItem->note,
                'donated_by' => $request->get('donated_by_' . $cartItem->cart_item_id) ?? '',
                'schedule' => $cartItem->period === 20 ? 'Number: ' . $order->account_number . ', Sort: ' . $order->sort_code . ', Day: ' . $order->pay_day : '',
                'account_number' => $cartItem->period === 20 ? $request->account_number : null,
                'sort_code' => $cartItem->period === 20 ? $request->sort_code : null,
                'pay_day' => $cartItem->period === 20 ? $request->schedule : null,
                'ip' => $request->ip(),
                'upsell' => $cartItem->upsell,
                'goal' => $cartItem->goal,
                'name' => $cartItem->name,
            ]);

            $donationName = 'Quick Donation';
            if (isset($cartItem->campaign)) {
                $donationName = $cartItem->campaign->name;
            } else if (isset($cartItem->foodpack)) {
                $donationName = $cartItem->foodpack->country->name . " FoodPack";
            } else if (isset($cartItem->foodpackqurbani)) {
                $donationName = $cartItem->foodpackqurbani->country->name . " Qurbani (" . $cartItem->foodpackqurbanitype->name . ")";
            } else if ($cartItem->upsell) {
                $donationName = $cartItem->name ?? 'Provide Rice This Eid';
            }

            $baseMetadata = [
                'donation_id' => $donation->id,
                'order_id' => $order->id,
                'campaign_id' => $cartItem->campaign_id,
            ];

            if ($cartItem->campaign) {
                $baseMetadata['campaign_name'] = $cartItem->campaign->name;
                $baseMetadata['campaign_country'] = $cartItem->campaign->country ? $cartItem->campaign->country->name : 'Not specified';

                if ($cartItem->period === CampaignPrice::TYPE_SINGLE) {
                    $baseMetadata['total_project_amount'] = $cartItem->amount;
                } else {
                    $baseMetadata['total_project_amount'] = $cartItem->goal;
                }
            } elseif ($cartItem->foodpack) {
                $baseMetadata['campaign_name'] = $cartItem->foodpack->country->name . " FoodPack";
                $baseMetadata['campaign_country'] = $cartItem->foodpack->country->name;

                if ($cartItem->period === CampaignPrice::TYPE_SINGLE) {
                    $baseMetadata['total_project_amount'] = $cartItem->amount;
                } else {
                    $baseMetadata['total_project_amount'] = $cartItem->goal;
                }
            } elseif ($cartItem->foodpackqurbani) {
                $baseMetadata['campaign_name'] = $cartItem->foodpackqurbani->country->name . " Qurbani (" . $cartItem->foodpackqurbanitype->name . ")";
                $baseMetadata['campaign_country'] = $cartItem->foodpackqurbani->country->name;

                if ($cartItem->period === CampaignPrice::TYPE_SINGLE) {
                    $baseMetadata['total_project_amount'] = $cartItem->amount;
                } else {
                    $baseMetadata['total_project_amount'] = $cartItem->goal;
                }
            } elseif ($cartItem->upsell) {
                $baseMetadata['campaign_name'] = $cartItem->name ?? 'Provide Rice This Eid';
                $baseMetadata['campaign_country'] = 'Not specified';
                $baseMetadata['total_project_amount'] = $cartItem->amount;
            } else {
                $baseMetadata['campaign_name'] = 'General';
                $baseMetadata['campaign_country'] = 'Not specified';
                $baseMetadata['total_project_amount'] = $cartItem->amount;
            }

            if ($cartItem->period !== 20) {
                $singleItems[] = [
                    'amount' => $cartItem->amount,
                    'name' => $donationName,
                    'donation_id' => $donation->id,
                    'metadata' => array_merge($baseMetadata, [
                        'donation_type' => 'single',
                    ])
                ];
            } else {
                $monthlyItems[] = [
                    'amount' => $cartItem->amount,
                    'name' => $donationName,
                    'donation_id' => $donation->id,
                    'metadata' => array_merge($baseMetadata, [
                        'donation_type' => 'monthly',
                    ])
                ];
            }
        }

        /*
         * -----------------------------------------------------------------------
         * Handle PayPal payments AFTER order and donation records are persisted
         * -----------------------------------------------------------------------
         */
        if ($request->get('pay_method') === 'paypal') {
            // Total (single-payment) amount – monthly donations are not processed via PayPal here
            $sum = $cartItems->sum('amount');

            if ($sum <= 0) {
                return back()->with('error', 'Unable to create PayPal payment for zero amount.');
            }

            $response = (object) Paypal::createOrder($sum, 'GBP', 'order-' . $order->id);

            if (isset($response->result->id)) {
                $order->order_id = $response->result->id;
                $order->pay_with = 'paypal';
                $order->save();

                foreach ($response->result->links as $link) {
                    if ($link->rel === 'approve') {
                        return redirect()->away($link->href);
                    }
                }
            }

            $error_message = 'Error creating PayPal payment.';
            if (isset($response->error) && is_object($response->error) && isset($response->error->message)) {
                $error_message .= ' ' . $response->error->message;
            } elseif (isset($response->error) && is_string($response->error)) {
                $error_message .= ' ' . $response->error;
            }

            return back()->with('error', $error_message);
        }

        $paymentResults = [];
        $requiresAction = false;
        $clientSecrets = [];

        try {
            if (!empty($singleItems)) {
                $singlePaymentResults = [];

                foreach ($singleItems as $singleItem) {
                    $paymentData = [
                        'amount' => $singleItem['amount'],
                        'currency' => 'gbp',
                        'customer_id' => $customer->id,
                        'description' => 'Islamic Help Donation - ' . $singleItem['name'],
                        'receipt_email' => $order->email,
                        'metadata' => array_merge($singleItem['metadata'], [
                            'order_id' => $order->id,
                            'donation_type' => 'single_payment_individual',
                        ])
                    ];

                    if ($request->has('payment_method_id')) {
                        $paymentData['payment_method'] = $request->payment_method_id;
                        $paymentData['confirm'] = true;
                    }

                    $paymentIntent = $this->stripeService->createDirectPayment($paymentData);

                    $singlePaymentResults[] = $paymentIntent;

                    if ($paymentIntent->status === 'succeeded') {
                        $donation = Donation::find($singleItem['donation_id']);
                        $donation->status = Donation::STATUS_COMPLETE;
                        $donation->stripe_payment_intent_id = $paymentIntent->id;
                        $donation->save();
                    } else if (in_array($paymentIntent->status, ['requires_action', 'requires_source_action'])) {
                        $donation = Donation::find($singleItem['donation_id']);
                        $donation->status = Donation::STATUS_PROCESSING;
                        $donation->stripe_payment_intent_id = $paymentIntent->id;
                        $donation->save();
                    }
                }

                $paymentResults['single_payments'] = $singlePaymentResults;
            }

            if (!empty($monthlyItems)) {
                $subscriptionResults = [];

                foreach ($monthlyItems as $item) {
                    $price = $this->stripeService->createDonationSubscriptionPrice([
                        'amount' => $item['amount'],
                        'name' => $item['name'],
                        'currency' => 'gbp',
                        'metadata' => $item['metadata']
                    ]);

                    $subscriptionData = [
                        'customer_id' => $customer->id,
                        'items' => [
                            [
                                'price' => $price->id,
                                'quantity' => 1,
                            ]
                        ],
                        'metadata' => [
                            'order_id' => $order->id,
                            'donation_id' => $item['donation_id'],
                            'campaign_id' => $item['metadata']['campaign_id'],
                            'donation_type' => 'monthly_subscription_individual',
                            'total_project_amount' => $item['metadata']['total_project_amount'] ?? $item['amount'],
                            'paid_amount' => 0,
                        ]
                    ];

                    if ($request->has('payment_method_id')) {
                        $subscriptionData['default_payment_method'] = $request->payment_method_id;
                    }

                    $subscription = $this->stripeService->createSubscriptionPayment($subscriptionData);

                    $subscriptionResults[] = $subscription;

                    if (
                        $subscription->status === 'incomplete' &&
                        isset($subscription->latest_invoice->payment_intent) &&
                        $subscription->latest_invoice->payment_intent->status === 'requires_action'
                    ) {
                        $requiresAction = true;
                        $clientSecrets[] = $subscription->latest_invoice->payment_intent->client_secret;
                    }

                    $donation = Donation::find($item['donation_id']);
                    if ($subscription->status === 'active') {
                        $donation->status = Donation::STATUS_COMPLETE;
                    } else {
                        $donation->status = Donation::STATUS_PROCESSING;
                    }
                    $donation->stripe_subscription_id = $subscription->id;
                    $donation->save();
                }

                $paymentResults['subscriptions'] = $subscriptionResults;
            }

            $order->pay_with = 'stripe';
            if (!empty($monthlyItems)) {
                $order->pay_with = 'Number: ' . $order->account_number . ', Sort: ' . $order->sort_code . ', Day: ' . $order->pay_day;
            }
            $order->order_id = hash('sha1', Str::random(10) . (empty($monthlyItems) ? 'single' : 'monthly'));

            if (isset($paymentResults['single_payments'])) {
                $order->order_id = $order->stripe_payment_intent_id = $paymentResults['single_payments'][0]->id;
            }
            if (isset($paymentResults['subscriptions'])) {
                $order->stripe_subscription_id = $paymentResults['subscriptions'][0]->id;
                if ($order->order_id) {
                    $order->order_id .= ", " . $order->stripe_subscription_id;
                } else {
                    $order->order_id = $order->stripe_subscription_id;
                }
            }

            $order->save();

            $this->clearCart();

            $this->sendThankYouEmail($order);

            $thanksUrl = Page::getSinglePageUrl(Template::THANK_YOU_DONATE_PAGE);
            $url = url($thanksUrl . '?order=' . $order->order_id);

            // If the request expects a JSON response (e.g. AJAX Payment Request flow) – return JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'success'         => !$requiresAction,
                    'requires_action' => $requiresAction,
                    'client_secrets'  => $clientSecrets,
                    'redirect_url'    => $url,
                ]);
            }

            return redirect()->to($url);

        } catch (\Exception $e) {
            Log::error('Payment processing failed: ' . $e->getMessage());

            foreach ($singleItems as $item) {
                $donation = Donation::find($item['donation_id']);
                $donation->status = Donation::STATUS_CANCELED;
                $donation->save();
            }

            foreach ($monthlyItems as $item) {
                $donation = Donation::find($item['donation_id']);
                $donation->status = Donation::STATUS_CANCELED;
                $donation->save();
            }

            return back()->with('error', 'Payment processing failed: ' . $e->getMessage());
        }
    }

    protected function sessionCartPut($itemId)
    {
        $cart = session()->get('cart');
        $cart[] = $itemId;
        session()->put('cart', $cart);
    }

    protected function sessionCartDelete($itemId)
    {
        $cart = session()->get('cart');
        $key = array_search($itemId, $cart);

        if ($key !== false) {
            unset($cart[$key]);
        }

        session()->put('cart', $cart);
    }

    protected function refreshItemQuantity($cartItemId, $quantity)
    {
        $needItem = CartItem::where('id', $cartItemId)->first();

        if ($needItem) {
            $sameItems = $needItem->getSameItems();
            $totalItems = count($sameItems);

            if ($needItem->period == CampaignPrice::TYPE_MONTHLY) {
                $collection = collect($sameItems);
                $totalAmount = $collection->sum('amount');
                $price = $totalAmount / $totalItems;

                if ($price * $quantity > 2000) {
                    return false;
                }
            }

            if ($quantity > $totalItems) {
                $newItemIds = $needItem->createSameItems($quantity - $totalItems);

                foreach ($newItemIds as $cartId) {
                    $this->sessionCartPut($cartId);
                }
            } else if ($quantity < $totalItems) {
                $deletedItemIds = $needItem->removeSameItems($totalItems - $quantity);

                foreach ($deletedItemIds as $cartId) {
                    $this->sessionCartDelete($cartId);
                }
            }
        }

        return true;
    }

    public function refreshQuantity(Request $request)
    {
        $cart = $request->get('cart');

        foreach ($cart as $item) {
            if (!$this->refreshItemQuantity($item['id'], $item['quantity'])) {
                return response()->json([
                    'message' => 'Error',
                    'success' => false,
                    'error' => 'big_monthly_donate',
                    'cart_html' => view('parts.modal_cart')->render(),
                    'cart_donate' => view('modules.presentation.donation_page_cart')->render(),
                    'sum' => CartItem::getCartSum(),
                    'sum_for_view' => CartItem::roundCurrency(CartItem::getCartSum()),
                    'commission' => StripeService::countCommission(CartItem::getCartSum()),
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'cart_html' => view('parts.modal_cart')->render(),
            'cart_donate' => view('modules.presentation.donation_page_cart')->render(),
            'sum' => CartItem::getCartSum(),
            'sum_for_view' => CartItem::roundCurrency(CartItem::getCartSum()),
            'commission' => StripeService::countCommission(CartItem::getCartSum()),
        ]);
    }

    //  Icharme Setup start from here
    public function getallcities(Request $request)
    {
        $post = $request->all();
        if ($request->ajax()) {
            $country_id = $post['country_id'];
            $url = config('config.ICHARM_API_URL') . '/v2/city?apikey=' . config('config.ICHARM_API_KEY') . '&country_id=' . $country_id;
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $dataAr = json_decode($response, TRUE);
            return $dataAr['data'];
        }
    }



    public function getCampaignList($campName = '')
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, config('config.ICHARM_API_URL') . '/v2/campaign?apikey=' . config('config.ICHARM_API_KEY'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        $dataAr = json_decode($result, TRUE);
        curl_close($ch);
        foreach ($dataAr['data'] as $key => $data) {
            if ($data['campaign_name'] == $campName) {
                return $data['campaign_id'];
            }
        }
    }

    public function addCampaign($campName = '')
    {
        $startDay = date("Y-m-d");
        $newEndingDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($startDay)) . " + 1 year"));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config('config.ICHARM_API_URL') . '/v2/campaign');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $post = array(
            'apikey' => config('config.ICHARM_API_KEY'),
            'name' => $campName,
            'start_date' => $startDay,
            'end_date' => $newEndingDate
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return json_decode($result, TRUE);
    }

    public function getCategoryList($category = '')

    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, config('config.ICHARM_API_URL') . '/v2/category?apikey=' . config('config.ICHARM_API_KEY'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        $dataAr = json_decode($result, TRUE);
        curl_close($ch);
        Log::debug(json_encode($result));
        foreach ($dataAr['data'] as $key => $data) {
            if ($data['category_name'] == $category) {
                return $data['category_id'];
            }
        }
    }
    public function getDonationRef($ref = '')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config('config.ICHARM_API_URL') . '/v2/donation/' . $ref . '?apikey=' . config('config.ICHARM_API_KEY'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        $dataAr = json_decode($result, TRUE);
        curl_close($ch);
        // echo "<pre>"; print_r( $dataAr);


    }

    public function getProgramList()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config('config.ICHARM_API_URL') . '/v2/program?apikey=' . config('config.ICHARM_API_KEY'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $dataAr = json_decode($result, TRUE);
        return $dataAr;
    }


    //  Icharme Setup end from here

}

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
        $DonationCollection = [];
        $AllDonationData = [];
        $cartIds = session()->get('cart');
        $country = Country::find(intval($request->get('country')));
        $cartItems = CartItem::whereIn('cart_item_id', $cartIds)->get();
        $orderData = $request->all();
        $orderData['country'] = $country ? $country->name : '';
        $order = Order::create($orderData);
        $sum = 0;
        $items = [];

        $totalDonations = $cartItems->count();
        if ($cartItems->where('period', 20)->sum('amount') > config('config.max_monthly_donate')) {
            return back()->with('error', "For donations of this value please contact our team on 0121 446 568.");
        }

        foreach ($cartItems as $key => $cartItem) {
            if ($cartItem->period !== 20) {
                $sum = $sum + $cartItem->amount;
            }
            //  ====================================  Donation Data AssignMent Start ======================================
            // $AllDonationData['user_details'] = $request->all();
            // $AllDonationData['user_details']['title'] = $request->title;
            // $AllDonationData['user_details']['total_amount'] = $cartItem->amount;
            // $AllDonationData['user_details']['pay_method'] = ($request->pay_method === 'paypal') ? 'paypal' : 'global';
            // $categoryName = CampaignCategory::where('id', $cartItem->campaign_category_id)->first(); // sadqah
            // $startDay = date("Y");
            // $newEndingDate = date("Y", strtotime(date("Y", strtotime($startDay)) . " + 1 year"));
            // $icharmeIdsFromDb = Campaign::where('id', $cartItem->campaign_id)->select(['icharm_program_id', 'icharm_country_id', 'name'])->first();
            // $CampaignName = (!empty($icharmeIdsFromDb->name)) ? $icharmeIdsFromDb->name : 'Annual Campaign - ' . $startDay . ' - ' . $newEndingDate . '';
            // $AllDonationData['user_details']['categoryName'] = (!empty($categoryName)) ? $categoryName->name : '';
            // $AllDonationData['user_details']['campaignName'] = $CampaignName;

            // $AllDonationData['user_details']['IcharmCategoryId'] =  (!empty($categoryName->name)) ? $this->getCategoryList($categoryName->name) : 19;
            // $campaignId = (!empty($AllDonationData['user_details']['campaignName'])) ?  $this->getCampaignList($AllDonationData['user_details']['campaignName']) : 683;

            // if(!empty($AllDonationData['user_details']['campaignName'])){
            //     $res = $this->addCampaign($AllDonationData['user_details']['campaignName']);
            //      if(isset($res['success']) && $res['success'] == 1){
            //         $AllDonationData['user_details']['IcharmcCampaignId'] = $this->getCampaignList($AllDonationData['user_details']['campaignName']);
            //      }
            // }else{
            //    $AllDonationData['user_details']['IcharmcCampaignId'] = $campaignId;
            // }
            // $AllDonationData['user_details']['IcharmcCampaignId'] = 696; // As per request campaign Is set to default


            // $AllDonationData['user_details']['IcharmProgramId'] =  (!empty($icharmeIdsFromDb->icharm_program_id)) ? $icharmeIdsFromDb->icharm_program_id : 28;

            // if ($AllDonationData['user_details']['IcharmProgramId'] == 28) {
            //     $AllDonationData['user_details']['icharmCountryId'] = 19;
            // } else {
            //     $AllDonationData['user_details']['icharmCountryId'] =  (!empty($icharmeIdsFromDb->icharm_country_id)) ? $icharmeIdsFromDb->icharm_country_id : 19;
            // }

            if ($cartItem->period == 20) {
                if ($this->blackListService->isBlackIp($request->ip())) {
                    return back()->with('error', "Sorry, your ip ({$request->ip()}) is blocked. Please contact our support.");
                }
            }


            //  ====================================  Donation Data AssignMent End ======================================
            $donation =  Donation::create([
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
                $donationName =  $cartItem->campaign->name;
            } else  if (isset($cartItem->foodpack)) {
                $donationName =  $cartItem->foodpack->country->name . " FoodPack";
            } else  if (isset($cartItem->foodpackqurbani)) {
                $donationName =  $cartItem->foodpackqurbani->country->name . " Qurbani (" . $cartItem->foodpackqurbanitype->name . ")";
            } else if ($cartItem->upsell) {
                $donationName = $cartItem->name ?? 'Provide Rice This Eid';
            }
            if ($cartItem->period !== 20) {
                $items[] = [
                    'price_data' => [
                        'currency' => 'gbp',
                        'product_data' => [
                            'name' => $donationName,
                        ],
                        'unit_amount' => $cartItem->amount * 100,
                    ],
                    'quantity' => 1,
                ];
            }

            // $AllDonationData['user_details']['order_id'] =  'IH-donationID-' . $donationId->id;
            // $DonationCollection[] = $AllDonationData;
        }

        $this->clearCart();
        $response = null;
        $payLink = null;
        $order->pay_with = $request->pay_method;
        $IcharmDontion = [];
        if ($sum > 0) {
            if ($request->pay_method === 'paypal') {
                $response = Paypal::createOrder($sum, 'GBP', 'Order id: ' . $order->id);

                $order->order_id = $response->result->id;
                $OrderId = $response->result->id;

                $payLink = $response->result->links[1]->href;
                $order->save();
            } else if ($request->pay_method === 'stripe') {
                $thanksUrl = Page::getSinglePageUrl(Template::THANK_YOU_DONATE_PAGE);
                $url = url($thanksUrl . '?order={CHECKOUT_SESSION_ID}');
                $sum = $sum * 100;
                \Stripe\Stripe::setApiKey(config('stripe.secret_key'));

                if ($request->stripe_fee) {
                    $items[] = [
                        'price_data' => [
                            'currency' => 'gbp',
                            'product_data' => [
                                'name' => 'Payment processing fee',
                            ],
                            'unit_amount' => StripeService::countCommissionPence($sum),
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
                $order->save();
            } else {
                $thanksUrl = Page::getSinglePageUrl(Template::THANK_YOU_DONATE_PAGE);
                $url = url($thanksUrl . '?order={CHECKOUT_SESSION_ID}');
                $sum = $sum * 100;


                $session = \Stripe\Checkout\Session::create([
                    'line_items' => [[
                        'currency' => 'gbp',
                        'name' => 'Monthly donation',
                        'amount' => 500,
                        'quantity' => 1
                    ]],
                    'mode' => 'subscription',
                    'success_url' => $url,
                    'cancel_url' => route('index'),
                    'customer_email' => $order->email,
                ]);

                $payLink = $session->url;
                $order->order_id = $session->id;
                $order->save();
                $sum = $sum * 100;

                $payment = new GlobalPay($sum, 'GBP', [
                    'email' => $request->get('email'),
                    'first_name' => $request->get('first_name'),
                    'last_name' => $request->get('last_name'),
                    'post_code' => $request->get('post_code'),
                    'phone' => $request->get('phone'),
                    'address_1' => $request->get('address_1'),
                    'address_2' => $request->get('address_2'),
                    'city' => $request->get('city'),
                    'notes' => $request->get('notes'),
                    'country' => $country ? $country->name : '',
                    'county' => $request->get('county')
                ]);
                $order->order_id = $payment->orderId;

                $OrderId  = $payment->orderId;

                $responce = $payment->getPayLink();

                if (isset($responce['hppPayByLink'])) {
                    $payLink = $responce['hppPayByLink'];
                } else {
                    dd($responce);
                }
                $order->save();
            }

            if (empty($payLink)) {
                die('Bad request');
            }

            // //  ====================================  Store donation Data in Temp Table ======================================
            // foreach ($DonationCollection as $key => $donation) {
            //     $aRR = [
            //         'order_id' => $OrderId,
            //         'donation_data' => serialize($donation['user_details'])
            //     ];
            //     TempStoreDonationData::create($aRR);
            // }
            // //  ====================================  Store donation Data in Temp Table ======================================

            return redirect($payLink);
        } else if (count($cartItems) > 0 && $sum == 0 && SettingHelper::get(SettingHelper::ENABLE_STRIPE)) {
            // monthly donation
            \Stripe\Stripe::setApiKey(config('stripe.secret_key'));
            $stripePlan = $this->stripeService->createPlan($cartItems, $order->email);
            $thanksUrl = Page::getSinglePageUrl(Template::THANK_YOU_DONATE_PAGE);
            $url = url($thanksUrl . '?order={CHECKOUT_SESSION_ID}');

            $metadata = $stripePlan->metadata->toArray();
            $campaigns = array_keys($metadata);
            $description = implode(', ', $campaigns) . " monthly direct debit by Islamic Help";

            $session = \Stripe\Checkout\Session::create([
                'mode' => 'subscription',
                'success_url' => $url,
                'cancel_url' => route('index'),
                'customer_email' => $order->email,
                'line_items' => [[
                    'price' => $stripePlan->id,
                    'quantity' => 1
                ]],
                'subscription_data' => [
                    'metadata' => $metadata,
                    'description' => $description,
                ],
                'payment_method_types' => [
                    'card',
                    'bacs_debit',
                ]
            ]);
            $payLink = $session->url;
            $order->order_id = $session->id;
            $order->pay_with = 'stripe';
            $order->save();
            return redirect($payLink);
        }

        $order->pay_with = 'Number: ' . $order->account_number . ', Sort: ' . $order->sort_code . ', Day: ' . $order->pay_day;
        $order->order_id = hash('sha1', Str::random(10) . 'monthly');
        foreach ($order->donations as $donation) {
            // $AllDonationData[]['user_details']['order_id']= $order->order_id;
            $donation->status = Donation::STATUS_COMPLETE;
            $donation->save();
        }
        $order->save();
        $this->sendThankYouEmail($order);
        $thanksUrl = Page::getSinglePageUrl(Template::THANK_YOU_DONATE_PAGE);
        $url = url($thanksUrl . '?order=' . $order->order_id);
        return redirect()->to($url);
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

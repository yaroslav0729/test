<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Order;
use App\Models\Page;
use App\Models\SubscriptionTmp;
use App\Models\Template;
use App\Services\HubspotService;
use App\Services\Paypal;
use App\Services\StripeService;
use App\Traits\SendThankYouEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Subscription;

class PaymentController extends Controller
{
    use SendThankYouEmail;

    private StripeService $stripeService;
    private HubspotService $hubspotService;

    public function __construct(StripeService $stripeService, HubspotService $hubspotService)
    {
        $this->stripeService = $stripeService;
        $this->hubspotService = $hubspotService;
    }

    public function paypalPaymentSuccess(Request $request)
    {
        $orderId = $request->get('token');
        $payerID = $request->get('PayerID');

        // $authResponse = Paypal::authorizeOrder($orderId);
        $paypalResponse = Paypal::captureOrder($orderId);

        $order = Order::where('order_id', $orderId)->firstOrFail();

        foreach ($order->donations as $donation) {
            $donation->status = Donation::STATUS_COMPLETE;
            $donation->save();
        }

        $thanksUrl = Page::getSinglePageUrl(Template::THANK_YOU_DONATE_PAGE);

        $this->sendThankYouEmail($order);

        if ($thanksUrl === url('/')) {
            die('Page with template "' . Template::getLabel(Template::THANK_YOU_DONATE_PAGE) . '" is not found.');
        }
        $url = url($thanksUrl . '?order=' . $order->order_id);
        return redirect()->to($url);
    }

    public function paypalPaymentCancel(Request $request)
    {
        $orderId = $request->get('token');
        $payerID = $request->get('PayerID');

        $order = Order::where('order_id', $orderId)->firstOrFail();

        foreach ($order->donations as $donation) {
            $donation->status = Donation::STATUS_CANCELED;
            $donation->save();
        }

        die('order id:' . $orderId . ' has been canceled');
    }

    public function stripePaymentSuccess(Request $request, StripeService $stripeService)
    {
        Log::error('stripePaymentSuccess');
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, config('stripe.endpoint_secret')
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            Log::error('UnexpectedValueException');
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            Log::error('SignatureVerificationException ' . config('stripe.secret_endpoint_secret') . ' ' . $sig_header);
            http_response_code(400);
            exit();
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $stripe = new \Stripe\StripeClient(config('stripe.secret_key'));
                /** @var Session $checkoutSession */
                $checkoutSession = $stripe->checkout->sessions->retrieve($event->data->object->id, []);

                if (isset($checkoutSession->metadata['portal_donation'])) {
                    return response()->json([
                        'message' => 'Portal Donation',
                        'success' => true,
                    ]);
                }

                if ($checkoutSession->metadata['scheduled_qurbani']) {
                    $customer_id = $checkoutSession->customer;
                    $setupIntent = $stripe->setupIntents->retrieve($checkoutSession->setup_intent);
                    $payment_method_id = $setupIntent->payment_method;
                    $payment_method = $stripe->paymentMethods->retrieve($payment_method_id)->attach(['customer' => $customer_id]);
                    $customer = $stripe->customers->update($customer_id, ['invoice_settings' => ['default_payment_method' => $payment_method_id]]);

                    $order = Order::findOrFail($checkoutSession->metadata->order_id);
                    $plan = $this->stripeService->createScheduledQurbaniPlan($order->donations);
                    $stripe->subscriptionSchedules->create([
                        'customer' => $customer_id,
                        'start_date' => $checkoutSession->metadata->billing_anchor,
                        'end_behavior' => 'cancel',
                        'phases' => [
                            [
                                'metadata' => [
                                    'scheduled_qurbani' => true,
                                ],
                                'items' => [
                                    [
                                        'price' => $plan->id,
                                        'quantity' => 1,
                                    ],
                                ],
                                'iterations' => 1,
                            ],
                        ],
                        'metadata' => [
                            'scheduled_qurbani' => true,
                        ],
                    ]);
                    $this->sendThankYouScheduledQurbaniEmail($order);

                    return response()->json([
                        'message' => 'Success',
                        'success' => true,
                    ]);
                }

                if ($checkoutSession->setup_intent) {
                    $setupIntent = $stripe->setupIntents->retrieve($checkoutSession->setup_intent, []);

                    $customer = $stripe->customers->retrieve($checkoutSession->customer, []);
                    if (isset($checkoutSession->metadata['ramadan_subscription_setup']) && $checkoutSession->metadata['ramadan_subscription_setup'] === 'true') {
                        $plansCount = intval($checkoutSession->metadata['plans_count']);
                        Log::error('plansCount: ' . $plansCount);
                        $items = [];
                        for ($i = 0; $i < $plansCount; $i++) {
                            Log::error('plan_' . $i . '_id: ' . $checkoutSession->metadata['plan_' . $i . '_id']);
                            $items[] = [
                                'price' => $checkoutSession->metadata['plan_' . $i . '_id'],
                                'quantity' => 1,
                            ];
                        }
                        if ($this->stripeService->customerHaveSubscriptionWithItems($customer->id, $items)
                            || $this->stripeService->customerHaveGeneralSubscriptionWithItems($customer->id, $items)) {
                            return response()->json([
                                'message' => 'Aborting. Duplication',
                                'success' => true,
                            ]);
                        }
                        $phases = [
                            [
                                'metadata' => [
                                    'Donation type' => 'Daily Ramadan subscription',
                                    'subscription_type' => 'daily-ramadan',
                                    'billing_anchor' => $checkoutSession->metadata['billing_anchor'],
                                ],
                                'items' => $items,
                                'proration_behavior' => 'none',
                                'end_date' => $checkoutSession->metadata['end_date'],
                            ],
                        ];
                        $stripe->subscriptionSchedules->create([
                            'start_date' => $checkoutSession->metadata['billing_anchor'],
                            'customer' => $customer->id,
                            'end_behavior' => 'cancel',
                            'default_settings' => [
                                'default_payment_method' => $setupIntent->payment_method,
                            ],
                            'phases' => $phases,
                            'metadata' => [
                                'Donation type' => 'Daily Ramadan subscription',
                                'subscription_type' => 'daily-ramadan',
                                'billing_anchor' => $checkoutSession->metadata['billing_anchor'],
                            ],
                        ]);
                    } else {
                        SubscriptionTmp::query()
                            ->where('customer_email', $customer->email)
                            ->each(function (SubscriptionTmp $item) {
                                $this->stripeService->createScheduleSubscribe($item->payload);

                                $item->delete();
                            });
                    }

                    $stripe->customers->update(
                        $customer->id,
                        [
                            'invoice_settings' => [
                                'default_payment_method' => $setupIntent->payment_method,
                            ],
                        ]
                    );

                    return response()->json([
                        'message' => 'Success',
                        'success' => true,
                    ]);
                }

                $order = Order::where('order_id', $event->data->object->id)->firstOrFail();
                foreach ($order->donations as $donation) {
                    $donation->status = Donation::STATUS_COMPLETE;
                    $donation->save();
                }

                if (isset($event->data->object->subscription)) {
                    $order->subscription_id = $event->data->object->subscription;
                    $order->is_subscription_active = true;
                    $order->save();
                }

                $thanksUrl = Page::getSinglePageUrl(Template::THANK_YOU_DONATE_PAGE);
                $this->sendThankYouEmail($order);
                try {
                    $this->hubspotService->importDonations($order->donations);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    Log::error('Error importing donations to Hubspot. Order id ' . $order->id);
                }

                if ($thanksUrl === url('/')) {
                    die('Page with template "' . Template::getLabel(Template::THANK_YOU_DONATE_PAGE) . '" is not found.');
                }

                return response()->json([
                    'message' => 'Success',
                    'success' => true,
                ]);
            case 'invoice.payment_succeeded':
                $invoice = $event->data->object;

                $stripe = new \Stripe\StripeClient(config('stripe.secret_key'));
                $invoice = $stripe->invoices->retrieve($invoice->id);
                $subscription = $stripe->subscriptions->retrieve($invoice->subscription);

                if (isset($subscrition->metadata['portal_donation'])) {
                    return response()->json([
                        'message' => 'Portal donation',
                        'success' => true,
                    ]);
                }

                if (isset($subscription->metadata['donated_campaigns'])) {
                    $subscriptionId = $invoice->subscription;
                    $subscription = $this->stripeService->fetchSubscription($subscriptionId);
                    Log::error('Invoice paid for subscription ' . $subscriptionId);

                    $subscriptionInvoices = $this->stripeService->fetchInvoicesBySubscription($subscriptionId);
                    Log::error('Subscription has ' . count($subscriptionInvoices->data) . ' invoice(s).');

                    $order = Order::where('subscription_id', $subscriptionId)->firstOrFail();
                    $donationsCount = isset($subscription->metadata['donated_campaigns']) ? $subscription->metadata['donated_campaigns'] : count($order->donations) / (count($subscriptionInvoices->data) - 1);
                    $donations = $order->donations()->take($donationsCount)->get();

                    $subscriptionMetadata = $subscription->metadata->toArray();

                    if (isset($subscriptionMetadata['with_goal'])) {
                        $fullyPaid = false;
                        foreach ($donations as $donation) {
                            $goal = intval($subscriptionMetadata['Goal for campaign #' . $donation->campaign_id]);
                            $paid = intval($subscriptionMetadata['Paid for campaign #' . $donation->campaign_id]);

                            $paid = $donation->value + $paid;
                            $subscriptionMetadata['Paid for campaign #' . $donation->campaign_id] = $paid;
                            if ($paid >= $goal) {
                                $fullyPaid = true;
                            }
                        }

                        $stripe->subscriptions->update($subscriptionId, ['metadata' => $subscriptionMetadata]);

                        if ($fullyPaid) {
                            $subscription->cancel();
                        }
                    }

                    if (count($subscriptionInvoices->data) > 1) {
                        $lastInvoice = $subscriptionInvoices->data[0];
                        if (floatval($lastInvoice->amount_due) === $order->sum) {
                            $createdTime = now();
                            foreach ($donations as $key => $donation) {
                                $newDonation = $donation->replicate();
                                $newDonation->created_at = $createdTime;
                                $newDonation->is_recurring = true;
                                $newDonation->save();
                                Log::error('Created new donation ' . $newDonation->id . ' for order ' . $order->id);
                            }
                            $this->hubspotService->importDonations($donations);
                        }
                    }
                } else {
                    $donations = collect();

                    if (isset($subscription->items)) {
                        foreach ($subscription->items->data as $data) {
                            $payload = [
                                'value' => $data->plan->metadata->value,
                                'order_id' => $data->plan->metadata->order_id,
                                'type' => $data->plan->metadata->type,
                                'currency' => $data->plan->metadata->currency,
                                'user_id' => $data->plan->metadata->user_id,
                                'email' => $data->plan->metadata->email,
                                'note' => $data->plan->metadata->note,
                                'ip' => $data->plan->metadata->ip,
                                'status' => Donation::STATUS_COMPLETE,
                            ];

                            if (isset($data->plan->metadata->type_donation)) {
                                $campaignId = Campaign::query()
                                    ->updateOrCreate([
                                        'name' => $data->plan->metadata->type_donation,
                                        'country_id' => $data->plan->metadata->country_id,
                                    ])
                                    ->id;

                                $payload['campaign_id'] = $campaignId;
                            }

                            $donation = Donation::create($payload);

                            $donations->push($donation);
                        }
                    } else {
                        $payload = [
                            'value' => $subscription->plan->metadata->value,
                            'order_id' => $subscription->plan->metadata->order_id,
                            'type' => $subscription->plan->metadata->type,
                            'currency' => $subscription->plan->metadata->currency,
                            'user_id' => $subscription->plan->metadata->user_id,
                            'email' => $subscription->plan->metadata->email,
                            'note' => $subscription->plan->metadata->note,
                            'ip' => $subscription->plan->metadata->ip,
                            'status' => Donation::STATUS_COMPLETE,
                        ];

                        if (isset($subscription->plan->metadata->type_donation)) {
                            $campaignId = Campaign::query()
                                ->updateOrCreate([
                                    'name' => $subscription->plan->metadata->type_donation,
                                    'country_id' => $subscription->plan->metadata->country_id,
                                ])
                                ->id;

                            $payload['campaign_id'] = $campaignId;
                        }

                        $donation = Donation::create($payload);

                        $donations->push($donation);
                    }

                    $sum = $donations->sum(function ($donation) {
                        return $donation->value;
                    });

                    $thanksUrl = Page::getSinglePageUrl(Template::THANK_YOU_DONATE_PAGE);
                    $this->sendThankEmailRamadan($donations, $invoice->total, $invoice->period_end);

                    if ($thanksUrl === url('/')) {
                        die('Page with template "' . Template::getLabel(Template::THANK_YOU_DONATE_PAGE) . '" is not found.');
                    }
                }

                return response()->json([
                    'message' => 'Success',
                    'success' => true,
                ]);
            case 'invoice.paid':
                $invoice = $event->data->object;
                return response()->json([
                    'message' => 'Success',
                    'success' => true,
                ]);
            case 'subscription_schedule.created':
                return response()->json([
                    'message' => 'Success',
                    'success' => true,
                ]);
            default:
                return response()->json([
                    'message' => 'Success',
                    'success' => true,
                ]);
        }
        return response()->json([
            'message' => 'Error',
            'success' => false,
        ], 400);
    }
}

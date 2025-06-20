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

        // Verify request is from Stripe
        if (!isset($_SERVER['HTTP_STRIPE_SIGNATURE'])) {
            Log::error('No Stripe signature found');
            http_response_code(400);
            exit();
        }

        // Read raw POST data
        $payload = @file_get_contents('php://input');
        if ($payload === false) {
            Log::error('Failed to read POST data');
            http_response_code(400);
            exit();
        }

        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, config('stripe.endpoint_secret')
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            Log::error('UnexpectedValueException: ' . $e->getMessage());
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            Log::error('SignatureVerificationException: ' . $e->getMessage());
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

                if (isset($checkoutSession->metadata['website_key']) && $checkoutSession->metadata['website_key'] !== config('stripe.website_key')) {
                    return response()->json([
                        'message' => 'Different website key',
                        'success' => true,
                    ]);
                }

                if ($checkoutSession->metadata['scheduled_qurbani']) {
                    $customer_id = $checkoutSession->customer;
                    $order = Order::findOrFail($checkoutSession->metadata['order_id']);

                    if ($checkoutSession->mode === 'payment') { // This was a "pay now" scheduled Qurbani
                        // Ensure donations are marked as complete
                        foreach ($order->donations as $donation) {
                            if ($donation->status !== Donation::STATUS_COMPLETE) {
                                $donation->status = Donation::STATUS_COMPLETE;
                                $donation->save();
                            }
                        }
                        // The 'payment_intent' is in $checkoutSession->payment_intent
                        // This confirms payment was made.
                    } else if ($checkoutSession->mode === 'setup') { // This was "schedule for later"
                        $setupIntent = $stripe->setupIntents->retrieve($checkoutSession->setup_intent);
                        $payment_method_id = $setupIntent->payment_method;
                        $stripe->paymentMethods->retrieve($payment_method_id)->attach(['customer' => $customer_id]);
                        $stripe->customers->update($customer_id, ['invoice_settings' => ['default_payment_method' => $payment_method_id]]);

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
                        // Donations for 'setup' mode are already STATUS_SCHEDULED from ScheduledSacrificeController
                    }

                    $this->sendThankYouScheduledQurbaniEmail($order);

                    try {
                        $this->hubspotService->importDonations($order->donations);
                    } catch (\Exception $e) {
                        Log::error($e->getMessage());
                        Log::error('Error importing scheduled qurbani donations to Hubspot. Order id ' . $order->id);
                    }

                    return response()->json([
                        'message' => 'Success',
                        'success' => true,
                    ]);
                }

                if ($checkoutSession->setup_intent) {
                    $setupIntent = $stripe->setupIntents->retrieve($checkoutSession->setup_intent, []);

                    $customer = $stripe->customers->retrieve($checkoutSession->customer, []);
                    if (isset($checkoutSession->metadata['dom_subscription_setup']) && $checkoutSession->metadata['dom_subscription_setup'] === 'true') {
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
                                    'Donation type' => 'Days of Mercy subscription',
                                    'subscription_type' => 'days-of-mercy',
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
                                'Donation type' => 'Days of Mercy subscription',
                                'subscription_type' => 'days-of-mercy',
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

                if (isset($subscription->metadata['website_key']) && $subscription->metadata['website_key'] !== config('stripe.website_key')) {
                    return response()->json([
                        'message' => 'Different website key',
                        'success' => true,
                    ]);
                }

                if (isset($subscription->metadata['donation_type']) && $subscription->metadata['donation_type'] === 'monthly_subscription_individual') {
                    $donationId = $subscription->metadata['donation_id'] ?? null;

                    // Update paid amount and evaluate goal
                    $goalAmount = isset($subscription->metadata['total_project_amount']) ? floatval($subscription->metadata['total_project_amount']) : null;
                    $alreadyPaid = isset($subscription->metadata['paid_amount']) ? floatval($subscription->metadata['paid_amount']) : 0;
                    $currentPayment = $invoice->total / 100; // Stripe totals are in pence/cents
                    $newPaid = $alreadyPaid + $currentPayment;

                    // Prepare metadata update
                    $metadataUpdate = $subscription->metadata->toArray();
                    $metadataUpdate['paid_amount'] = $newPaid;

                    // Persist donation record if provided
                    if ($donationId) {
                        $donation = Donation::find($donationId);
                        if ($donation) {
                            if (!$donation->invoice_id) {
                                $donation->invoice_id = $invoice->id;
                            }
                            $donation->status = Donation::STATUS_COMPLETE;
                            $donation->save();
                        }
                    }

                    // Update subscription metadata with new paid amount
                    $stripe->subscriptions->update($subscription->id, ['metadata' => $metadataUpdate]);

                    // Cancel subscription if goal reached or exceeded
                    if ($goalAmount && $newPaid >= $goalAmount) {
                        $stripe->subscriptions->cancel($subscription->id);
                    }

                    return response()->json([
                        'message' => 'Success',
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

                    $originalDonations = $order->donations()->where('is_recurring', false)->get();
                    foreach ($originalDonations as $donation) {
                        if (!$donation->invoice_id) {
                            $donation->invoice_id = $invoice->id;
                            $donation->save();
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

                            $donation = new Donation($payload);

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

                        $donation = new Donation($payload);

                        $donations->push($donation);
                    }

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
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;

                // Ignore events that belong to another website installation
                if (isset($paymentIntent->metadata['website_key']) && $paymentIntent->metadata['website_key'] !== config('stripe.website_key')) {
                    return response()->json([
                        'message' => 'Different website key',
                        'success' => true,
                    ]);
                }

                // Process completed one-off payments that were created via the new checkout flow
                if (isset($paymentIntent->metadata['donation_id'])) {
                    $donation = Donation::find($paymentIntent->metadata['donation_id']);
                    if ($donation) {
                        $donation->status = Donation::STATUS_COMPLETE;
                        $donation->stripe_payment_intent_id = $paymentIntent->id;
                        $donation->save();
                    }
                }

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
    }
}

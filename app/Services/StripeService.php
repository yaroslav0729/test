<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\Plan;
use Stripe\Product;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Subscription;
use Stripe\SubscriptionSchedule;
use Stripe\PaymentIntent;

class StripeService
{
    public const CURRENCY_GBP = 'gbp';
    private const INTERVAL_DAY = 'day';
    const CURRENCY_USD = 'usd';

    private StripeClient $stripe;

    private array $baseMetadata;

    public function __construct()
    {
        $this->stripe = new StripeClient(
            config('stripe.secret_key')
        );
        $this->baseMetadata = [
            'website_key' => config('stripe.website_key'),
        ];

        Stripe::setApiKey(config('stripe.secret_key'));
    }

    public function combineWithBaseMetadata(array $metadata): array
    {
        return array_merge($this->baseMetadata, $metadata);
    }

    /**
     * @throws ApiErrorException
     */
    public function processCustomer(array $data): Customer
    {
        $customer = $this->stripe->customers->search([
            'query' => 'email:\'' . $data['email'] . '\'',
        ]);

        if (!$customer->isEmpty()) {
            return $customer->data[0];
        }

        return $this->stripe->customers->create([
            'name' => $data['first_name'] . ' ' . $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => [
                'city' => $data['city'],
                'line1' => $data['address_1'],
                'line2' => $data['address_2'],
                'postal_code' => $data['post_code'],
            ],
        ]);
    }

    public function processUser(array $data, Customer $customer): User
    {
        /** @var User $user */
        $user = User::query()->where('email', $data['email'])->first();

        if (!$user) {
            $user = User::create([
                'name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'title' => $data['title'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make(Str::random()),
                'address_1' => $data['address_1'],
                'address_2' => $data['address_2'],
                'city' => $data['city'],
                'country' => $data['country'],
                'post_code' => $data['post_code'],
            ]);
        }
        $user->stripe_customer_id = $customer->id;
        $user->save();

        return $user;
    }

    public function createProduct(string $name): Product
    {
        return Product::create([
            'name' => $name,
            'type' => 'service',
        ]);
    }

    public function getCheckeoutSessionUrl(Collection $plans, Customer $customer, string $url, bool $isFuture = false, $billingAnchor = null, $endDate = null): string
    {
        $payload = [];

        if ($isFuture) {
            $payload = [
                'mode' => 'setup',
                'payment_method_types' => ['card'],
                'success_url' => $url,
                'customer' => $customer->id,
            ];
        } else {
            $plansMetadata = [];
            $totalPrice = 0;
            foreach ($plans as $index => $plan) {
                $plansMetadata['plan_' . $index . '_id'] = $plan->id;
                $totalPrice += $plan->amount;
            }
            $totalPrice = $totalPrice / 100;
            $metadata = array_merge([
                'dom_subscription_setup' => true,
                'plans_count' => count($plans),
                'billing_anchor' => $billingAnchor,
            ], $plansMetadata);
            if ($billingAnchor) {
                $metadata['billing_anchor'] = $billingAnchor;
            }
            if ($endDate) {
                $metadata['end_date'] = $endDate;
            }
            $payload = [
                'mode' => 'setup',
                'success_url' => $url,
                'customer' => $customer->id,
                'payment_method_types' => ['card'],
                'currency' => 'gbp',
                'custom_text' => [
                    'after_submit' => [
                        'message' => 'Subscription. £' . $totalPrice . ' will be charged daily.',
                    ],
                ],
                'metadata' => $this->combineWithBaseMetadata($metadata),
            ];
        }

        return Session::create($payload)->url;
    }

    public function createPlanRamadan(Product $product, Customer $customer, float $amount, array $donation, int $interval = 1): Plan
    {
        $currency = $customer->currency === self::CURRENCY_USD ? self::CURRENCY_USD : self::CURRENCY_GBP;

        return Plan::create([
            'product' => $product->id,
            'nickname' => 'Daily Subscription Plan',
            'currency' => $currency,
            'interval' => self::INTERVAL_DAY,
            'interval_count' => $interval,
            'amount' => round($amount * 100, 0),
            'metadata' => $this->combineWithBaseMetadata($donation),
        ]);
    }

    private function getStripePortalUrlByCustomerId(string $customerId): string
    {
        $portal = $this->stripe->billingPortal->sessions->create([
            'customer' => $customerId,
            'return_url' => config('app.url') . '/dashboard',
        ]);

        return $portal->url;
    }

    public function prepareLineItemsForSession(Collection $plans): array
    {
        return $plans
            ->map(static function (Plan $plan) {
                return [
                    'price' => $plan->id,
                    'quantity' => 1,
                ];
            })
            ->toArray();
    }

    public static function countCommissionPence($sum): int
    {
        return (int)((int)(((($sum + 23) / (1 - 0.029)) - $sum) * 100) / 100);
    }

    public static function countCommission($sum): float
    {
        return ((int)(((($sum + 0.23) / (1 - 0.029)) - $sum) * 100)) / 100;
    }

    /**
     * @throws ApiErrorException
     */
    public function createPlan($cartItems, $userEmail): Plan
    {
        $sum = 0;
        $metadata = [];

        $withGoal = false;
        $donationCampaigns = [];

        foreach ($cartItems as $key => $cartItem) {
            $sum = $sum + $cartItem->amount;
            if ($cartItem->goal) {
                $withGoal = true;
            }
            $donationName = 'Monthly donation';
            if (isset($cartItem->campaign)) {
                $donationName =  $cartItem->campaign->name;
            } else  if (isset($cartItem->foodpack)) {
                $donationName =  $cartItem->foodpack->country->name . " FoodPack";
            } else  if (isset($cartItem->foodpackqurbani)) {
                $donationName =  $cartItem->foodpackqurbani->country->name . " Qurbani (" . $cartItem->foodpackqurbanitype->name . ")";
            } else if ($cartItem->upsell) {
                $donationName = $cartItem->name ?? 'Provide Rice This Eid';
            }
            $metadata[substr($donationName, 0, 40)] = $cartItem->amount . '£';
            $donationCampaigns[] = $donationName;
            $metadata['Goal for campaign #' . $cartItem->campaign_id] = $cartItem->goal;
            $metadata['Paid for campaign #' . $cartItem->campaign_id] = 0;
        }
        $metadata['donated_campaigns'] = count($cartItems);
        if ($withGoal) {
            $metadata['with_goal'] = true;
        }
        $metadata = $this->combineWithBaseMetadata($metadata);

        return $this->stripe->plans->create([
            'amount' => $sum * 100,
            'currency' => 'gbp',
            'interval' => 'month',
            'product' => [
                'name' => implode(', ', $donationCampaigns) . " monthly direct debit by Islamic Help",
                'metadata' => $metadata
            ],
            'metadata' => $metadata
        ]);
    }

    public function createScheduledQurbaniPlan($donations): Plan
    {
        $sum = 0;

        foreach ($donations as $donation) {
            $sum = $sum + $donation->value;
        }

        return $this->stripe->plans->create([
            'amount' => $sum * 100,
            'currency' => 'gbp',
            'interval' => 'month',
            'product' => [
                'name' => 'Scheduled Sacrifice',
            ],
        ]);
    }

    /**
     * @throws ApiErrorException
     */
    public function cancelSubscription(string $subscriptionId): Subscription
    {
        $subscription = $this->stripe->subscriptions->retrieve($subscriptionId, []);
        $planId = $subscription->items->data[0]->price->id;
        $plan = $this->stripe->plans->retrieve($planId, []);

        $subscription->cancel();
        $plan->delete();

        return $subscription;
    }

    public function fetchInvoicesBySubscription(string $subscriptionId): \Stripe\Collection
    {
        return $this->stripe->invoices->all([
            'subscription' => $subscriptionId
        ]);
    }

    public function fetchUpcomingInvoicesForSubscription(string $subscriptionId): \Stripe\Invoice
    {
        return $this->stripe->invoices->upcoming([
            'subscription' => $subscriptionId
        ]);
    }

    public function fetchSubscription(string $subscriptionId): Subscription
    {
        return $this->stripe->subscriptions->retrieve($subscriptionId);
    }

    /**
     * @throws ApiErrorException
     */
    public function getSession(string $order): Session
    {
        return $this->stripe->checkout->sessions->retrieve($order);
    }

    /**
     * @throws ApiErrorException
     */
    public function getSubscription(Session $session)
    {
        return $this->stripe->subscriptions->retrieve($session->subscription);
    }

    public function getActiveSubscriptions($startingAfter = '', $limit = 100): \Stripe\Collection
    {
        $params = [
            'limit' => $limit,
        ];

        if ($startingAfter) {
            $params['starting_after'] = $startingAfter;
        }

        return $this->stripe->subscriptions->all($params);
    }

    public function fetchUpcomingInvoice(string $subscriptionId): \Stripe\Invoice
    {
        return $this->stripe->invoices->upcoming([
            'subscription' => $subscriptionId
        ]);
    }

    public function setCancelAt($subscription, string $endDate)
    {
        $this->stripe->subscriptions->update(
            $subscription,
            [
                'cancel_at' => Carbon::parse($endDate)->timestamp,
            ]
        );
    }

    public function createScheduleSubscribe(array $data)
    {
        SubscriptionSchedule::create($data);
    }

    public function getSubscriptionById(string $subscriptionId)
    {
        return $this->stripe->subscriptions->retrieve($subscriptionId);
    }

    public function getSubscriptionByProductId(string $productId)
    {
        return $this->stripe->subscriptions->search([
            'query' => 'product:\'' . $productId . '\''
        ]);
    }

    public function getAllSubscriptionAfterDate(int $timestamp)
    {
        return $this->stripe->subscriptions->all([
            'created' => [
                'gt' => $timestamp,
            ],
        ]);
    }

    public function getAllSubscriptionBeforeDate(int $timestamp)
    {
        return $this->stripe->subscriptions->all([
            'created' => [
                'lt' => $timestamp
            ],
        ]);
    }

    public function cancelSubscriptionById(string $subscriptionId)
    {
        $this->stripe->subscriptions->cancel($subscriptionId);
    }

    public function getStripeClient(): StripeClient
    {
        return $this->stripe;
    }

    public function getCustomerScheduledSubscriptions(string $customerId): \Stripe\Collection
    {
        return $this->stripe->subscriptionSchedules->all([
            'customer' => $customerId,
        ]);
    }

    public function customerHaveSubscriptionWithItems(string $customerId, array $items): bool
    {
        $subscriptions = $this->getCustomerScheduledSubscriptions($customerId);
        $subscriptions = $subscriptions->data;
        $scheduledSubscriptions = array_filter($subscriptions, function ($subscription) use ($items) {
            if (count($items) === count($subscription->phases[0]->items)) {
                $hasAllItems = true;
                foreach ($items as $item) {
                    $found = false;
                    foreach($subscription->phases[0]->items as $subscriptionItem) {
                        if ($subscriptionItem->price === $item['price']) {
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        $hasAllItems = false;
                        break;
                    }
                }
                return $hasAllItems;
            }
            return false;
        });

        return count($scheduledSubscriptions) > 0;
    }

    public function customerHaveGeneralSubscriptionWithItems(string $customerId, array $items): bool
    {
        $subscriptions = $this->stripe->subscriptions->all(['customer' => $customerId]);
        $subscriptions = $subscriptions->data;
        $filteredSubscriptions = array_filter($subscriptions, function ($subscription) use ($items) {
            if (count($items) === count($subscription->items->data)) {
                $hasAllItems = true;
                foreach ($items as $item) {
                    $found = false;
                    foreach($subscription->items->data as $subscriptionItem) {
                        if ($subscriptionItem->price->id === $item['price']) {
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        $hasAllItems = false;
                        break;
                    }
                }
                return $hasAllItems;
            }
            return false;
        });

        return count($filteredSubscriptions) > 0;
    }

    public $items = [
        [
            'price' => 'plan_PkaFMav8xOZrJU',
            'quantity' => 1,
        ],
        [
            'price' => 'plan_PkaFrYobmO60YU',
            'quantity' => 1,
        ],
        [
            'price' => 'plan_PkaFbIXrEaUnDl',
            'quantity' => 1,
        ],
        [
            'price' => 'plan_PkaFnFHixSj4zR',
            'quantity' => 1,
        ],
        [
            'price' => 'plan_PkaFdQ5hjbFlgY',
            'quantity' => 1,
        ],
        [
            'price' => 'plan_PkaFZLOaxuZuU6',
            'quantity' => 1,
        ],
    ];

    /**
     * Create a direct payment using PaymentIntent API
     * For immediate payments without user interaction, you may need to confirm the payment separately
     * or provide a payment method to enable auto-confirmation
     *
     * @param array $data Payment data containing amount, currency, customer info, etc.
     * @return PaymentIntent
     * @throws ApiErrorException
     */
    public function createDirectPayment(array $data): PaymentIntent
    {
        $paymentData = [
            'amount' => $data['amount'] * 100, // Convert to cents
            'currency' => $data['currency'] ?? self::CURRENCY_GBP,
            'automatic_payment_methods' => [
                'enabled' => true,
                'allow_redirects' => 'never',
            ],
            'metadata' => $this->combineWithBaseMetadata($data['metadata'] ?? []),
        ];

        // Add customer if provided
        if (isset($data['customer_id'])) {
            $paymentData['customer'] = $data['customer_id'];
        }

        // Add payment method if provided
        if (isset($data['payment_method'])) {
            $paymentData['payment_method'] = $data['payment_method'];
            $paymentData['confirm'] = true; // Auto-confirm if payment method is provided
        }

        // Add auto-confirmation for immediate payment (requires setup intent or saved payment method)
        if (isset($data['auto_confirm']) && $data['auto_confirm'] === true) {
            $paymentData['confirm'] = true;
            $paymentData['return_url'] = $data['return_url'] ?? config('app.url');
        }

        // Add description if provided
        if (isset($data['description'])) {
            $paymentData['description'] = $data['description'];
        }

        // Add receipt email if provided
        if (isset($data['receipt_email'])) {
            $paymentData['receipt_email'] = $data['receipt_email'];
        }

        // Add shipping information if provided
        if (isset($data['shipping'])) {
            $paymentData['shipping'] = $data['shipping'];
        }

        return $this->stripe->paymentIntents->create($paymentData);
    }

    /**
     * Confirm a payment intent
     *
     * @param string $paymentIntentId
     * @param array $data Additional data for confirmation
     * @return PaymentIntent
     * @throws ApiErrorException
     */
    public function confirmPayment(string $paymentIntentId, array $data = []): PaymentIntent
    {
        return $this->stripe->paymentIntents->confirm($paymentIntentId, $data);
    }

    /**
     * Retrieve a payment intent
     *
     * @param string $paymentIntentId
     * @return PaymentIntent
     * @throws ApiErrorException
     */
    public function getPaymentIntent(string $paymentIntentId): PaymentIntent
    {
        return $this->stripe->paymentIntents->retrieve($paymentIntentId);
    }

    /**
     * Cancel a payment intent
     *
     * @param string $paymentIntentId
     * @return PaymentIntent
     * @throws ApiErrorException
     */
    public function cancelPayment(string $paymentIntentId): PaymentIntent
    {
        return $this->stripe->paymentIntents->cancel($paymentIntentId);
    }

    /**
     * Create a subscription with immediate payment
     *
     * @param array $data Subscription data
     * @return Subscription
     * @throws ApiErrorException
     */
    public function createSubscriptionPayment(array $data, bool $expand = false): Subscription
    {
        $subscriptionData = [
            'customer' => $data['customer_id'],
            'items' => $data['items'], // Array of ['price' => 'price_id', 'quantity' => 1]
            'metadata' => $this->combineWithBaseMetadata($data['metadata'] ?? []),
        ];

        // Add payment method if provided
        if (isset($data['default_payment_method'])) {
            $subscriptionData['default_payment_method'] = $data['default_payment_method'];
        }

        // Add trial period if provided
        if (isset($data['trial_period_days'])) {
            $subscriptionData['trial_period_days'] = $data['trial_period_days'];
        }

        // Add billing cycle anchor if provided
        if (isset($data['billing_cycle_anchor'])) {
            $subscriptionData['billing_cycle_anchor'] = $data['billing_cycle_anchor'];
        }

        // Add proration behavior if provided
        if (isset($data['proration_behavior'])) {
            $subscriptionData['proration_behavior'] = $data['proration_behavior'];
        }

        // Add coupon if provided
        if (isset($data['coupon'])) {
            $subscriptionData['coupon'] = $data['coupon'];
        }

        // Add collection method
        $subscriptionData['collection_method'] = $data['collection_method'] ?? 'charge_automatically';

        if ($expand) {
            return $this->stripe->subscriptions->create(
                $subscriptionData,
                ['expand' => ['latest_invoice.payment_intent']]
            );
        }

        return $this->stripe->subscriptions->create($subscriptionData);
    }

    /**
     * Schedule a future subscription
     *
     * @param array $data Scheduled subscription data
     * @return SubscriptionSchedule
     * @throws ApiErrorException
     */
    public function scheduleSubscription(array $data): SubscriptionSchedule
    {
        $scheduleData = [
            'customer' => $data['customer_id'],
            'start_date' => $data['start_date'], // Unix timestamp
            'phases' => [
                [
                    'items' => $data['items'], // Array of ['price' => 'price_id', 'quantity' => 1]
                    'iterations' => $data['iterations'] ?? null, // null for infinite
                ]
            ],
            'metadata' => $this->combineWithBaseMetadata($data['metadata'] ?? []),
        ];

        // Add end behavior if provided
        if (isset($data['end_behavior'])) {
            $scheduleData['end_behavior'] = $data['end_behavior']; // 'release', 'cancel'
        }

        // Add default payment method if provided
        if (isset($data['payment_method'])) {
            $scheduleData['default_settings'] = [
                'default_payment_method' => $data['payment_method']
            ];
        }

        // Add trial period to phase if provided
        if (isset($data['trial_period_days'])) {
            $scheduleData['phases'][0]['trial_period_days'] = $data['trial_period_days'];
        }

        // Add billing cycle anchor to phase if provided
        if (isset($data['billing_cycle_anchor'])) {
            $scheduleData['phases'][0]['billing_cycle_anchor'] = $data['billing_cycle_anchor'];
        }

        // Add coupon to phase if provided
        if (isset($data['coupon'])) {
            $scheduleData['phases'][0]['coupon'] = $data['coupon'];
        }

        return $this->stripe->subscriptionSchedules->create($scheduleData);
    }

    /**
     * Schedule a future one-time payment
     *
     * @param array $data Scheduled payment data
     * @return array Returns scheduling information
     * @throws ApiErrorException
     */
    public function scheduleOneTimePayment(array $data): array
    {
        // Create a payment intent that will be processed later
        $paymentData = [
            'amount' => $data['amount'] * 100, // Convert to cents
            'currency' => $data['currency'] ?? self::CURRENCY_GBP,
            'customer' => $data['customer_id'],
            'capture_method' => 'manual', // Don't capture immediately
            'confirmation_method' => 'manual', // Manual confirmation
            'metadata' => $this->combineWithBaseMetadata(array_merge(
                $data['metadata'] ?? [],
                [
                    'scheduled_for' => $data['scheduled_date'],
                    'payment_type' => 'scheduled_one_time'
                ]
            )),
        ];

        // Add payment method if provided
        if (isset($data['payment_method'])) {
            $paymentData['payment_method'] = $data['payment_method'];
        }

        // Add description if provided
        if (isset($data['description'])) {
            $paymentData['description'] = $data['description'];
        }

        // Add receipt email if provided
        if (isset($data['receipt_email'])) {
            $paymentData['receipt_email'] = $data['receipt_email'];
        }

        $paymentIntent = $this->stripe->paymentIntents->create($paymentData);

        return [
            'payment_intent_id' => $paymentIntent->id,
            'client_secret' => $paymentIntent->client_secret,
            'status' => $paymentIntent->status,
            'scheduled_date' => $data['scheduled_date'],
            'amount' => $data['amount'],
            'currency' => $data['currency'] ?? self::CURRENCY_GBP,
        ];
    }

    /**
     * Process a scheduled one-time payment
     *
     * @param string $paymentIntentId
     * @param array $data Additional confirmation data
     * @return PaymentIntent
     * @throws ApiErrorException
     */
    public function processScheduledPayment(string $paymentIntentId, array $data = []): PaymentIntent
    {
        // First confirm the payment intent
        $paymentIntent = $this->stripe->paymentIntents->confirm($paymentIntentId, $data);

        // Then capture the payment if confirmation was successful
        if ($paymentIntent->status === 'requires_capture') {
            $paymentIntent = $this->stripe->paymentIntents->capture($paymentIntentId);
        }

        return $paymentIntent;
    }

    /**
     * Update a scheduled subscription
     *
     * @param string $scheduleId
     * @param array $data Update data
     * @return SubscriptionSchedule
     * @throws ApiErrorException
     */
    public function updateScheduledSubscription(string $scheduleId, array $data): SubscriptionSchedule
    {
        $updateData = [];

        // Update phases if provided
        if (isset($data['phases'])) {
            $updateData['phases'] = $data['phases'];
        }

        // Update end behavior if provided
        if (isset($data['end_behavior'])) {
            $updateData['end_behavior'] = $data['end_behavior'];
        }

        // Update metadata if provided
        if (isset($data['metadata'])) {
            $updateData['metadata'] = $this->combineWithBaseMetadata($data['metadata']);
        }

        return $this->stripe->subscriptionSchedules->update($scheduleId, $updateData);
    }

    /**
     * Cancel a scheduled subscription
     *
     * @param string $scheduleId
     * @return SubscriptionSchedule
     * @throws ApiErrorException
     */
    public function cancelScheduledSubscription(string $scheduleId): SubscriptionSchedule
    {
        return $this->stripe->subscriptionSchedules->cancel($scheduleId);
    }

    /**
     * Release a subscription schedule (convert to regular subscription)
     *
     * @param string $scheduleId
     * @return SubscriptionSchedule
     * @throws ApiErrorException
     */
    public function releaseSubscriptionSchedule(string $scheduleId): SubscriptionSchedule
    {
        return $this->stripe->subscriptionSchedules->release($scheduleId);
    }

    /**
     * Create a price for individual donation subscription
     *
     * @param array $data Price data containing amount, name, metadata
     * @return \Stripe\Price
     * @throws ApiErrorException
     */
    public function createDonationSubscriptionPrice(array $data): \Stripe\Price
    {
        // Create product first
        $product = $this->createProduct($data['name']);

        // Create price for this specific donation
        $priceData = [
            'currency' => $data['currency'] ?? self::CURRENCY_GBP,
            'unit_amount' => $data['amount'] * 100, // Convert to pence
            'recurring' => [
                'interval' => $data['interval'] ?? 'month',
            ],
            'product' => $product->id,
            'metadata' => $this->combineWithBaseMetadata($data['metadata'] ?? []),
        ];

        return $this->stripe->prices->create($priceData);
    }

    /**
     * Create and immediately process a payment using customer's default payment method
     * This method is suitable for backend processing after customer has set up payment method
     *
     * @param array $data Payment data
     * @return PaymentIntent
     * @throws ApiErrorException
     */
    public function createAndConfirmPayment(array $data): PaymentIntent
    {
        // First create the payment intent
        $paymentIntent = $this->createDirectPayment($data);

        // If customer has a default payment method, use it to confirm
        if (isset($data['customer_id'])) {
            $customer = $this->stripe->customers->retrieve($data['customer_id']);

            if ($customer->invoice_settings->default_payment_method) {
                return $this->confirmPayment($paymentIntent->id, [
                    'payment_method' => $customer->invoice_settings->default_payment_method
                ]);
            }
        }

        // If no default payment method, return the intent for manual confirmation
        return $paymentIntent;
    }

    /**
     * Attaches a PaymentMethod to a Customer and sets it as the default.
     *
     * @param string $paymentMethodId
     * @param string $customerId
     * @return \Stripe\PaymentMethod
     * @throws ApiErrorException
     */
    public function attachPaymentMethodToCustomer(string $paymentMethodId, string $customerId): \Stripe\PaymentMethod
    {
        // Attach the PaymentMethod to the Customer.
        $paymentMethod = $this->stripe->paymentMethods->attach($paymentMethodId, [
            'customer' => $customerId
        ]);

        // Set it as the default payment method for the customer's invoices.
        $this->stripe->customers->update($customerId, [
            'invoice_settings' => [
                'default_payment_method' => $paymentMethodId,
            ],
        ]);

        return $paymentMethod;
    }
}

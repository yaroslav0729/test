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

class StripeService
{
    public const CURRENCY_GBP = 'gbp';
    private const INTERVAL_DAY = 'day';
    const CURRENCY_USD = 'usd';

    private StripeClient $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(
            config('stripe.secret_key')
        );

        Stripe::setApiKey(config('stripe.secret_key'));
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

        $user->update([
            'stripe_customer_id' => $customer->id,
            'stripe_portal_url' => $this->getStripePortalUrlByCustomerId($customer->id),
        ]);

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
                'ramadan_subscription_setup' => true,
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
                'metadata' => $metadata,
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
            'metadata' => $donation
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
                $donationName = 'Provide Rice This Eid';
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

    public function fetchInvoicesBySubscription(string $subscriptionId): \Stripe\SearchResult
    {
        return $this->stripe->invoices->search([
            'query' => 'subscription:"' . $subscriptionId . '"'
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

        return count($subscriptions) > 0;
    }
}

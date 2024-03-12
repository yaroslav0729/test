<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Country;
use App\Models\Donation;
use App\Models\Order;
use App\Models\SubscriptionTmp;
use App\Traits\SendThankYouEmail;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use RuntimeException;
use Stripe\Customer;

class RamadanService
{
    use SendThankYouEmail;

    public string $startDate = '11-03-2024';
    public string $endDate = '10-04-2024';

    private StripeService $stripeService;
    private ConvertCurrency $convertCurrency;

    public function __construct(StripeService $stripeService, ConvertCurrency $convertCurrency)
    {
        $this->stripeService = $stripeService;
        $this->convertCurrency = $convertCurrency;
    }

    /**
     * @throws Exception
     */
    public function createDonates(array $donatesData, string $ip): string
    {
        try {
            $this->startDate = $donatesData['start_date'];
            $startDateCarbon = Carbon::createFromFormat('Y-m-d', $donatesData['start_date'], 'UTC');
            $this->endDate = $startDateCarbon->addDays(29)->format('d-m-Y');
            $customer = $this->stripeService->processCustomer($donatesData);
            $donatesData = $this->processDonateData($donatesData, $customer);
            $this->stripeService->processUser($donatesData, $customer);
            $countryName = $this->getCountryName((int)$donatesData['country']);
            $order = $this->createOrder($donatesData, $countryName);
            $plans = $this->createPlans($order, $customer, $donatesData, $ip);

            $startDate = $this->getStartDate((int)$donatesData['frequency']);

            $billingAnchor = $startDate->subHours(2)->timestamp;
            $endDate = Carbon::createFromFormat('d-m-Y', $this->endDate, 'UTC')->endOfDay()->subHours(2)->timestamp;
            return $this->prepareRedirectUrl($plans, $customer, in_array($donatesData['frequency'], [2, 3]) ? true : false, $billingAnchor, $endDate);
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    private function getCountryName(int $countryId): ?string
    {
        return Country::query()->find($countryId)->name ?? null;
    }

    private function prepareDonation(float $amount, Order $order, string $ip, string $typeDonation, int $countryId): array
    {
        return [
            'value' => $amount,
            'order_id' => $order->id,
            'type' => Donation::TYPE_RAMADAN,
            'currency' => 'GBP',
            'user_id' => auth()->user()->id ?? null,
            'email' => $order->email,
            'note' => 'My ten nights',
            'ip' => $ip,
            'type_donation' => mb_strtoupper($typeDonation),
            'country_id' => $countryId,
        ];
    }

    private function createOrder(array $donatesData, ?string $countryName): Order
    {
        return Order::create(array_merge($donatesData, ['country' => $countryName]));
    }

    private function prepareRedirectUrl(Collection $plans, Customer $customer, bool $isFuture = false, $billingAnchor = null, $endDate = null): string
    {
        $thanksUrl = route('stripe.ramadan.process');
        $url = url($thanksUrl . '?order={CHECKOUT_SESSION_ID}');

        return $this->stripeService->getCheckeoutSessionUrl($plans, $customer, $url, $isFuture, $billingAnchor, $endDate);
    }

    private function createPlans(Order $order, Customer $customer, array $donatesData, string $ip): Collection
    {
        $plans = collect();
        $plansOven = collect();
        $plansOdd = collect();

        $startDate = $this->getStartDate((int)$donatesData['frequency']);

        foreach ($donatesData['amount'] as $key => $value) {
            if ($value === null || (int)$value === 0) {
                continue;
            }

            $nameDonate = implode(' ', explode('_', $key));
            if ((int)$donatesData['frequency'] === 3) {
                ['couples' => $couples, 'odd' => $odd] = $this->prepareAmount((int)$value, $startDate);

                $donationOven = $this->prepareDonation($couples, $order, $ip, $nameDonate, (int)$donatesData['country']);
                $productOven = $this->stripeService->createProduct("{$nameDonate}. oven days");
                $planOven = $this->stripeService->createPlanRamadan($productOven, $customer, $couples, $donationOven, 2);

                $donationOdd = $this->prepareDonation($odd, $order, $ip, $nameDonate, (int)$donatesData['country']);
                $productOdd = $this->stripeService->createProduct("{$nameDonate}. odd days");
                $planOdd = $this->stripeService->createPlanRamadan($productOdd, $customer, $odd, $donationOdd, 2);

                $plansOven->push($planOven);
                $plansOdd->push($planOdd);
            } else {
                $countDay = Carbon::parse($this->endDate, 'UTC')->endOfDay()->diffInDays($startDate->endOfDay());
                if ((int)$donatesData['frequency'] === 1) {
                    $countDay += 1;
                }
                $donation = $this->prepareDonation((float)$value / $countDay, $order, $ip, $nameDonate, (int)$donatesData['country']);
                $product = $this->stripeService->createProduct($nameDonate);
                $plan = $this->stripeService->createPlanRamadan($product, $customer, $value / $countDay, $donation);
                $plans->push($plan);
            }
        }

        SubscriptionTmp::query()->where('customer_email', $customer->email)->delete();

        if ((int)$donatesData['frequency'] === 2) {
            $this
                ->createSubscriptionTmp(
                    $customer,
                    $startDate->subHours(2)->timestamp,
                    Carbon::parse($this->endDate, 'UTC')->endOfDay()->subHours(2)->timestamp,
                    $plans,
                );
        } elseif ((int)$donatesData['frequency'] === 3) {
            $this
                ->createSubscriptionTmp(
                    $customer,
                    $this->isOvenDay($startDate) ? $startDate->subHours(2)->timestamp : $startDate->addDay()->subHours(2)->timestamp,
                    Carbon::parse($this->endDate, 'UTC')->endOfDay()->subHours(2)->timestamp,
                    $plansOven,
                    'oven'
                );

            $this
                ->createSubscriptionTmp(
                    $customer,
                    $this->isOvenDay($startDate) ? $startDate->addDay()->subHours(2)->timestamp : $startDate->subHours(2)->timestamp,
                    Carbon::parse($this->endDate, 'UTC')->endOfDay()->subHours(2)->timestamp,
                    $plansOdd,
                    'odd'
                );
        }

        return $plans;
    }

    private function createSubscriptionTmp(Customer $customer, int $startTimestamp, int $endTimestamp, Collection $plans, ?string $type = null): void
    {
        $payload = [
            'customer' => $customer->id,
            'start_date' => $startTimestamp,
            'end_behavior' => 'cancel',
            'phases' => [
                [
                    'metadata' => [
                        'Donation type' => 'Last 10 nights subscription',
                        'subscription_type' => 'odd-even-ramadan',
                    ],
                    'items' => [$this->stripeService->prepareLineItemsForSession($plans)],
                    'end_date' => $endTimestamp,
                ],
            ],
        ];

        SubscriptionTmp::query()
            ->create(['customer_email' => $customer->email, 'payload' => $payload]);
    }

    public function prepareAmount($amount, Carbon $startDate): array
    {
        $days = Carbon::parse($this->endDate, 'UTC')->endOfDay()->diffInDays($startDate->endOfDay()) + 1;

        $even = round($amount / ($days * 1.5), 2);
        $odd = round($even * 2, 2);

        return [
            'couples' => $even,
            'odd' => $odd,
        ];
    }

    private function isOvenDay(Carbon $startDate): bool
    {
        return (bool)($startDate->day % 2) === false;
    }

    private function getStartDate(int $frequency): Carbon
    {
        if (Carbon::now()->gte(Carbon::parse($this->startDate)->subDays(10)) && $frequency === 1) {
            return Carbon::parse($this->startDate, 'UTC')->endOfDay();
        }

        if (Carbon::now()->lte(Carbon::parse($this->startDate)->subDays(10)) && $frequency === 1) {
            return Carbon::parse($this->startDate, 'UTC')->endOfDay();
        }

        if (Carbon::now()->gte(Carbon::parse($this->endDate)->subDays(10)) && in_array($frequency, [2, 3])) {
            return Carbon::now('UTC')->endOfDay();
        }

        return Carbon::parse($this->endDate)->subDays(10);
    }

    public function processSubcription(string $order): void
    {
        $session = $this->stripeService->getSession($order);

        $customer = $session->customer_details;

        if (isset($customer->toArray()['email'])) {
            $this->sendThankEmailForSubcription($customer->toArray()['email']);
        }

        if ($session->subscription === null) {
            return;
        }
        $subscriptionRetrieved = $this->stripeService->getSubscriptionById($session->subscription);

        if (isset($subscriptionRetrieved->items)) {
            foreach ($subscriptionRetrieved->items->data as $data) {
                if (isset($data->plan->metadata->type_donation)) {
                    $this->stripeService->setCancelAt($subscriptionRetrieved->id, $this->endDate);
                }
            }
        }
    }

    private function processDonateData(array $donatesData, Customer $customer): array
    {
        $rate = Cache::remember('rates', Carbon::tomorrow(), function() {
            return $this->convertCurrency->getRateUsdToGbp();
        });

        if ($customer->currency === StripeService::CURRENCY_GBP || $customer->currency === null) {
            return $donatesData;
        }

        $res['amount'] = [];
        foreach ($donatesData['amount'] as $key => $value) {
            if ($value === null || (int)$value === 0) {
                continue;
            }

            $res['amount'][$key] = $value / $rate['GBP'];
        }

        unset($donatesData['amount']);

        return array_merge($donatesData, $res);
    }
}

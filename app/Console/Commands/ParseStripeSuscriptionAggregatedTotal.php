<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Services\StripeService;
use Illuminate\Console\Command;
use Stripe\Stripe;
use Stripe\StripeClient;

class ParseStripeSuscriptionAggregatedTotal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:subscription-totals {subscription_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse stripe subscriptions and set aggregated total to metadata';

    private StripeService $stripeService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(StripeService $stripeService)
    {
        parent::__construct();
        $this->stripeService = $stripeService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = $this->stripeService->getStripeClient();
        $subId = $this->argument('subscription_id');

        if ($subId) {
            $this->parseOneSubscription($client, $subId);
        } else {
            $this->parseAllSubscriptions($client);
        }


        return 0;
    }

    private function parseOneSubscription(StripeClient $client, string $subId)
    {
        $subscription = $client->subscriptions->retrieve($subId);
        $subMetadata = $subscription->metadata->toArray();
        $donationsTotal = [];

        if (!isset($subMetadata['order_id']) && isset($subMetadata['donated_campaigns'])) {
            $this->info(' Subscription id ' . $subscription->id . ' donated from IH website');
            $order = Order::where('subscription_id', $subscription->id)->first();

            if (!$order) return;

            $this->info('Binded order ' . $order->id);
            $donations = $order->donations;

            foreach ($donations as $donation) {
                $donationName = $donation->type === 10 ? 'AMT for Single payment' : 'AMT for Monthly payment';
                if ($donation->campaign) {
                    $donationName = substr('AMT for ' . $donation->campaign->name, 0, 40);
                }


                if (!isset($donationsTotal[$donationName])) $donationsTotal[$donationName] = 0;
                $total = intval($donationsTotal[$donationName]);
                $donationsTotal[$donationName] = $total + $donation->value;
            }

            $metadata = array_merge($subMetadata, $donationsTotal);

            $client->subscriptions->update($subscription->id, [
                'metadata' => $metadata,
            ]);
        }
    }

    private function parseAllSubscriptions(StripeClient $client)
    {

        $ihSubsCount = 0;
        do {
            $subscriptions = $client->subscriptions->all([
                'limit' => 100,
            ]);

            foreach ($subscriptions->data as $subscription) {
                $subMetadata = $subscription->metadata->toArray();
                $donationsTotal = [];

                if (!isset($subMetadata['order_id']) && isset($subMetadata['donated_campaigns'])) {
                    $this->info(' Subscription id ' . $subscription->id . ' donated from IH website');
                    $order = Order::where('subscription_id', $subscription->id)->first();

                    if (!$order) continue;

                    $this->info('Binded order ' . $order->id);
                    $donations = $order->donations;

                    foreach ($donations as $donation) {
                        $donationName = $donation->type === 10 ? 'AMT for Single payment' : 'AMT for Monthly payment';
                        if ($donation->campaign) {
                            $donationName = substr('AMT for ' . $donation->campaign->name, 0, 40);
                        }


                        if (!isset($donationsTotal[$donationName])) $donationsTotal[$donationName] = 0;
                        $total = intval($donationsTotal[$donationName]);
                        $donationsTotal[$donationName] = $total + $donation->value;
                    }

                    $metadata = array_merge($subMetadata, $donationsTotal);

                    $client->subscriptions->update($subscription->id, [
                        'metadata' => $metadata,
                    ]);


                    $ihSubsCount++;
                }
            }
        } while ($subscriptions->has_more);

        $this->info('Total amount of IH subs: ' . $ihSubsCount);
    }
}
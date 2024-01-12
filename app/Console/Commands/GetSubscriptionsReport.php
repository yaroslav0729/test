<?php

namespace App\Console\Commands;

use App\Services\StripeService;
use Illuminate\Console\Command;
use Stripe\Exception\InvalidRequestException;

class GetSubscriptionsReport extends Command
{
    private StripeService $stripeService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripe:subscriptions-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetching subscriptions report from Stripe and saving it to file';

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

        $this->getSubscriptionList();

        return 0;
    }

    public function getSubscriptionList()
    {
        $subs = [];

        $stripeSubs = $this->stripeService->getActiveSubscriptions();
        $subs = $stripeSubs->data;

        $this->info('Fetching subscriptions...');
        while ($stripeSubs->has_more) {
            $stripeSubs = $this->stripeService->getActiveSubscriptions($stripeSubs->data[count($stripeSubs->data) - 1]->id);
            $subs = array_merge($subs, $stripeSubs->data);
        }

        $subsCollection = collect($subs);

        $sortedCollection = $subsCollection->sortBy(function ($sub) {
            return $sub->cancel_at ?? PHP_INT_MAX;
        });
        $this->info('Subscriptions fetched');

        sleep(1);

        $subsLinks = [];
        foreach ($sortedCollection as $sub) {
            $this->info('Fetching upcoming invoice for ' . $sub->id . '...');
            try {
                $upcomingInvoice = $this->stripeService->fetchUpcomingInvoice($sub->id);
            } catch (InvalidRequestException $e) {
                $this->warn('No upcoming invoice for ' . $sub->id . '...');
                continue;
            }
            if ($upcomingInvoice) {
                $this->info('Upcoming invoice fetched');
                $amountDue = $upcomingInvoice->amount_due;
                $planPrice = $sub->plan->amount;

                if ($amountDue != $planPrice) {
                    $this->info('Amount due is not equal to plan price');
                    $subsLinks[] = ['https://dashboard.stripe.com/subscriptions/' . $sub->id];
                }
            }
        }

        foreach ($subsLinks as $link) {
            $this->info($link[0]);
        }
    }
}

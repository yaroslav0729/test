<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Services\StripeService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FixMonthlyDonations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:monthly-donations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore donation records for recurring payments';

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
        $monthlyOrders = Order::whereNotNull('subscription_id')->get();
        $newDonationsCount = 0;
        foreach ($monthlyOrders as $order) {
            $donationsCount = $order->donations()->count();
            $this->info('Order ' . $order->id . ' has ' . $donationsCount . ' donations');
            $subscription = $this->stripeService->fetchSubscription($order->subscription_id);
            $invoices = $this->stripeService->fetchInvoicesBySubscription($order->subscription_id);
            $this->info('Order ' . $order->id . ' has ' . count($invoices->data) . ' invoices');
            $this->info('Order has next metadata: ' . $subscription->metadata['donated_campaigns']);


            if (count($invoices->data) > 1) {
                $donations = $order->donations()->take($subscription->metadata['donated_campaigns'])->get();
                for ($i = 0; $i < count($invoices->data) - 1; $i++) {
                    $invoiceDate = Carbon::createFromTimestamp($invoices->data[$i]->created);
                    foreach ($donations as $donation) {
                        $this->info('Fetched donation ' . $donation->id);
                        $newDonation = $donation->replicate();
                        $newDonation->created_at = $invoiceDate;
                        $newDonation->is_recurring = true;
                        $newDonation->save();
                        $newDonationsCount = $newDonationsCount + 1;
                        $this->info('Created new donation created for campaign' . $newDonation->campaign_id);
                    }
                }
            }
        }
        $this->info('Restored ' . $newDonationsCount . ' new donations');


        return 0;
    }
}

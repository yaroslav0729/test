<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Services\HubspotService;
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
    private HubspotService $hubspotService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(StripeService $stripeService, HubspotService $hubspotService)
    {
        parent::__construct();
        $this->stripeService = $stripeService;
        $this->hubspotService = $hubspotService;
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
            $invoices = collect($this->stripeService->fetchInvoicesBySubscription($order->subscription_id)->data)->reverse();
            $donatedCampaigns = $subscription->metadata['donated_campaigns'] ?? 0;
            $this->info('donated campaigns' . $donatedCampaigns);

            if ($donatedCampaigns < 1) {
                continue;
            }

            $originalDonations = $order->donations()->where('is_recurring', false)->get();
            $orderNumbers = intval($donationsCount / $originalDonations->count());
            if ($invoices->count() > $orderNumbers) {
                for ($i = 0; $i < $invoices->count(); $i++) {
                    if ($i === 0) {
                        foreach($originalDonations as $donation) {
                            $donation->invoice_id = $invoices[$i]->id;
                            $donation->save();
                        }
                    } else {
                        $invoiceDate = Carbon::createFromTimestamp($invoices[$i]->created);
                        $newDonationsCollection = collect();
                        foreach ($originalDonations as $donation) {
                            $newDonation = $donation->replicate();
                            $newDonation->created_at = $invoiceDate;
                            $newDonation->is_recurring = true;
                            $newDonation->invoice_id = $invoices[$i]->id;
                            $newDonation->save();
                            $newDonationsCollection->push($newDonation);
                            $newDonationsCount = $newDonationsCount + 1;
                        }

                        try {
                            $this->hubspotService->importDonations($newDonationsCollection);
                        } catch (\Exception $exception) {
                            $this->error('Failed to import donations: ' . $order->id);
                        }
                    }
                }
            }
        }
        $this->info('Restored ' . $newDonationsCount . ' new donations');


        return 0;
    }
}

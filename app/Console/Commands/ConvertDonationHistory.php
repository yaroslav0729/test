<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Campaign;
use \App\Models\Country;
use \App\Models\CampaignPrice;
use App\Models\CampaignCategory;
use App\Models\Donation;

class ConvertDonationHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan convert:donations
     * 
     * @var string
     */
    protected $signature = 'convert:donations';

    protected $wpConnection;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Convert donation history started...');
        $this->wpConnection = DB::connection('wp');

        $this->parseDonations();

        $this->info('Convert complete!');
    }

    protected function parseDonations()
    {
        $donations = $this->wpConnection->table('donate_items')->
                        join('donate_orders', 'donate_items.order_id', '=', 'donate_orders.id')
                        ->get();

        foreach ($donations as $donationKey => $donation) {
            $copyDonation = Donation::where('wp_id', $donation->id)->first();

            $additionalInfo = "";
            $additionalInfo = $donation->title;
            $additionalInfo = $additionalInfo . ' ' . $donation->first_name;
            $additionalInfo = $additionalInfo . ' ' . $donation->last_name;

            if ($copyDonation) {
                $copyDonation->update([
                    'value' => $donation->amount,
                    'type' => $donation->period === 0 ? CampaignPrice::TYPE_SINGLE : CampaignPrice::TYPE_MONTHLY,
                    'email' => $donation->email,
                    'note' => $additionalInfo, // $donation->message,
                ]);

                $infoString = $donationKey + 1 . ': Donation updated => id: ' . $copyDonation->id;
            } else {
                $copyDonation = Donation::create([
                    'value' => $donation->amount,
                    'type' => $donation->period === 0 ? CampaignPrice::TYPE_SINGLE : CampaignPrice::TYPE_MONTHLY,
                    'email' => $donation->email,
                    'note' => $additionalInfo,
                    'wp_id' => $donation->id,
                ]);

                $infoString = $donationKey + 1 . ': Donation created => id: ' . $copyDonation->id;
            }

            $this->info($infoString);
            Log::channel('parser')->info($infoString);

            if ($donationKey === 3) break;
        }
    }
}

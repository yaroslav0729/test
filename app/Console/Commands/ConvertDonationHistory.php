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
use App\Models\Order;

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
                        ->select('donate_items.*', 'donate_orders.*', 'donate_items.order_id as order_id', 'donate_orders.order_id as d_order_id' )
                        ->get();

        foreach ($donations as $donationKey => $donation) {
            $copyDonation = Donation::where('wp_id', $donation->id)->first();

            if ($copyDonation) {
                $copyDonation->update([
                    'value' => $donation->amount,
                    'type' => $donation->period === 0 ? CampaignPrice::TYPE_SINGLE : CampaignPrice::TYPE_MONTHLY,
                    'email' => $donation->email,
                    'note' => $donation->message,
                ]);

                $infoString = $donationKey + 1 . ': Donation updated => id: ' . $copyDonation->id;
            } else {
                $copyDonation = Donation::create([
                    'value' => $donation->amount,
                    'type' => $donation->period === 0 ? CampaignPrice::TYPE_SINGLE : CampaignPrice::TYPE_MONTHLY,
                    'email' => $donation->email,
                    'note' => $donation->message,
                    'wp_id' => $donation->id,
                ]);

                $infoString = $donationKey + 1 . ': Donation created => id: ' . $copyDonation->id;
            }

            $this->info($infoString);
            Log::channel('parser')->info($infoString);

            $copyOrder = Order::where('wp_id', $donation->order_id)->first();

            if ($copyOrder) {
                $copyOrder->update([
                    'title' => $donation->title,
                    'first_name' => $donation->first_name,
                    'last_name' => $donation->last_name,
                    'post_code' => $donation->post_code,
                    'address_1' => $donation->address_1,
                    'address_2' => $donation->address_2,
                    'address_3' => $donation->address_3,
                    'city' => $donation->city,
                    'state' => $donation->state,
                    'country' => $donation->country,
                    'phone' => $donation->phone,
                    'email' => $donation->email,
                    'notes' => $donation->notes,
                    'do_calls' => $donation->do_calls,
                    'do_sms' => $donation->do_sms,
                    'do_email' => $donation->do_email,
                    'pay_with' => $donation->pay_with,
                    'order_id' => $donation->d_order_id,
                    'wp_id' => $donation->order_id, 
                ]);

                $infoString = $donationKey + 1 . ': Order updated => id: ' . $copyOrder->id;
            } else {
                $copyOrder = Order::create([
                    'title' => $donation->title,
                    'first_name' => $donation->first_name,
                    'last_name' => $donation->last_name,
                    'post_code' => $donation->post_code,
                    'address_1' => $donation->address_1,
                    'address_2' => $donation->address_2,
                    'address_3' => $donation->address_3,
                    'city' => $donation->city,
                    'state' => $donation->state,
                    'country' => $donation->country,
                    'phone' => $donation->phone,
                    'email' => $donation->email,
                    'notes' => $donation->notes,
                    'do_calls' => $donation->do_calls,
                    'do_sms' => $donation->do_sms,
                    'do_email' => $donation->do_email,
                    'pay_with' => $donation->pay_with,
                    'order_id' => $donation->d_order_id,
                    'wp_id' => $donation->order_id,
                ]);

                $infoString = $donationKey + 1 . ': Order created => id: ' . $copyOrder->id;
            }

            $copyDonation->update([
                'order_id' => $copyOrder->id
            ]);

            $this->info($infoString);
            Log::channel('parser')->info($infoString);

            if ($donationKey === 3) break;
        }
    }
}

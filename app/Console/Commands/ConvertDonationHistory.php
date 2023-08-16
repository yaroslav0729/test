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
use App\Models\User;

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
        $donations = $this->wpConnection->table('donate_items')->join('donate_orders', 'donate_items.order_id', '=', 'donate_orders.id')
            ->select('donate_items.*', 'donate_orders.*', 'donate_items.order_id as order_id', 'donate_orders.order_id as d_order_id')
            ->where('donate_items.period', 1)
            ->whereNotNull('donate_items.schedule')
            ->get();

        $cou = count($donations);

        foreach ($donations as $donationKey => $donation) {
            $copyDonation = Donation::where('wp_id', $donation->id)->first();

            $userId = null;
            $donationUser = User::where('wp_id', $donation->user)->first();
            if ($donationUser) {
                $userId = $donationUser->id;
            }

            $amount = $donation->amount;

            if ($amount >= 1000000) {
                $amount = 0; // fix an error in WP database amount 1e38
            }

            $campaign = null;

            if ($donation->post_id != 0) {
                $campaign = Campaign::where(['wp_id' => $donation->post_id])->first();
            }

            if ($copyDonation) {
                $copyDonation->update([
                    'value' => $amount,
                    'status' => $donation->status,
                    'type' => $donation->period === 0 ? CampaignPrice::TYPE_SINGLE : CampaignPrice::TYPE_MONTHLY,
                    'email' => $donation->email,
                    'campaign_id' => $campaign ? $campaign->id : null,
                    'user_id' => $userId,
                    'currency' => 'GBP',
                    'campaign_category_id' => $this->getCampaignCategoryId($donation->type),
                    'note' => $donation->message,
                    'created_at' => $donation->created,
                ]);

                $infoString = $donationKey + 1 . ': Donation updated => id: ' . $copyDonation->id;
            } else {
                $copyDonation = Donation::create([
                    'value' => $amount,
                    'status' => $donation->status,
                    'type' => $donation->period === 0 ? CampaignPrice::TYPE_SINGLE : CampaignPrice::TYPE_MONTHLY,
                    'email' => $donation->email,
                    'currency' => 'GBP',
                    'user_id' => $userId,
                    'campaign_category_id' => $this->getCampaignCategoryId($donation->type),
                    'note' => $donation->message,
                    'wp_id' => $donation->id,
                    'created_at' => $donation->created,
                    'campaign_id' => $campaign ? $campaign->id : null,
                ]);

                $infoString = $donationKey + 1 . ': Donation created => id: ' . $copyDonation->id;
            }

            $this->info($infoString);
            Log::channel('parser')->info($infoString);

            $copyOrder = Order::where('wp_id', $donation->order_id)->first();

            $accountNumber = null;
            $sortCode = null;
            $payDay = null;

            if (!empty($donation->schedule)) {
                $scheduleParts = explode('. ', $donation->schedule);
                $accountNumber = explode('Number: ', $scheduleParts[0])[1];
                $sortCode = explode('Sort: ', $scheduleParts[1])[1];
                $payDay = explode('Day: ', $scheduleParts[2])[1];
                $copyDonation->update(['schedule' => 'Number: ' . $accountNumber . '. Sort: ' . $sortCode . '. Day: ' . $payDay]);
            }

            $createdAt = Carbon::createFromFormat('Y-m-d H:i:s', $donation->created);
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
                    'account_number' => $accountNumber,
                    'sort_code' => $sortCode,
                    'pay_day' => $payDay,
                    'order_id' => $donation->d_order_id,
                    'wp_id' => $donation->order_id,
                    'gift_aid' => $donation->gift_aid,
                    'created_at' => $createdAt,
                ]);

                $infoString = $donationKey + 1 . ' from ' . $cou . ': Order updated => id: ' . $copyOrder->id;
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
                    'account_number' => $accountNumber,
                    'sort_code' => $sortCode,
                    'pay_day' => $payDay,
                    'order_id' => $donation->d_order_id,
                    'wp_id' => $donation->order_id,
                    'gift_aid' => $donation->gift_aid,

                    'created_at' => $createdAt,
                ]);

                $infoString = $donationKey + 1 . ' from ' . $cou . ': Order created => id: ' . $copyOrder->id;
            }

            $copyDonation->update([
                'order_id' => $copyOrder->id
            ]);

            $this->info($infoString);
            Log::channel('parser')->info($infoString);
        }
    }

    protected function getCampaignCategoryId($wpType)
    {
        $categName = '';

        switch ($wpType) {
            case 10:
                $categName = 'Donation';
                break;
            case 11:
                $categName = 'Sadaqa';
                break;
            case 12:
                $categName = 'Fitrana';
                break;
            case 13:
                $categName = 'Zakat';
                break;
            case 14:
                $categName = 'Fidya';
                break;
            case 15:
                $categName = 'Kaffara';
                break;
            case 16:
                $categName = 'Interest';
                break;
            case 98:
                $categName =  'Qurbani';
                break;
            case 99:
                $categName = 'Sadaqa Qurbani';
                break;
            case 100:
                $categName = 'Aqeeqa';
                break;
        }

        $categ = CampaignCategory::where('name', $categName)->first();
        if (isset($categ)) return $categ->id;

        return null;
    }
}

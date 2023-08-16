<?php

namespace App\Traits;

use App\Models\TempStoreDonationData;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait IcharmData
{
    public function checkDonationPingCron()
    {
        $donationData  = DB::table('temp_store_donation_data as tmp')
            ->join('orders as odr', 'odr.order_id', '=', 'tmp.order_id')
            ->join('donations as dn', 'dn.order_id', '=', 'odr.id')
            ->whereNull(['tmp.sent_at'])
            ->where(['dn.status' => 1])
            ->get(['tmp.*'])->toArray();


        if (!empty($donationData)) {
            foreach ($donationData as $key => $donation) {
                $this->addDonationToIcharm(unserialize($donation->donation_data));
                TempStoreDonationData::where('id', $donation->id)->update(['sent_at' => now()]);
            }
        }
    }

    public function addDonationToIcharm($dataArr = [])
    {
        $title = (!empty($dataArr['title'])) ? ucfirst($dataArr['title']) : '';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config('config.ICHARM_API_URL') . '/v2/donation/create');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $post = array(
            'apikey' => config('config.ICHARM_API_KEY'),
            'title' => $title,
            'first_name' => $dataArr['first_name'],
            'last_name' => $dataArr['last_name'],
            'email' => $dataArr['email'],
            'phone' => $dataArr['phone'],
            'address_1' => $dataArr['address_1'],
            'address_2' => (!empty($dataArr['address_2'])) ? $dataArr['address_2'] : $dataArr['address_1'],
            'post_code' => $dataArr['post_code'],
            'city_id' => '1',
            'donation_date' => date("Y-m-d"),
            'pay_with' => $dataArr['pay_method'],
            'payment_transaction_no' => $dataArr['order_id'],
            'gift_aid' => '1',
            'donation_ref' => $dataArr['order_id'],
            'net_amount' => $dataArr['total_amount'],
            'campaign_id' =>  $dataArr['IcharmcCampaignId'], // default 696
            'program_id[ ]' => $dataArr['IcharmProgramId'], // 28
            'amount[ ]' => $dataArr['total_amount'],
            'country_id[ ]' => $dataArr['icharmCountryId'],
            'category_id[ ]' => $dataArr['IcharmCategoryId'],
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        } else {
            return json_decode($result, TRUE);
            // echo "<pre>"; print_r( $result); die;
        }
        curl_close($ch);
    }
}

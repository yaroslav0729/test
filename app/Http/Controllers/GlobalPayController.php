<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Order;
use App\Traits\SendThankYouEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GlobalPayController extends Controller
{
    use SendThankYouEmail;

    public function result(Request $request)
    {
        if (!empty($request->input('ORDER_ID'))) {

            $order = Order::where('order_id', $request->input('ORDER_ID'))->first();

            if (!empty($order)) {
                $donations = $order->donations;

                foreach ($donations as $donation) {
                    $donation->status = Donation::STATUS_COMPLETE;
                    $donation->save();
                }

                $this->sendThankYouEmail($order);
            }
        }

        return view('pages.global_pay_result');
    }
}

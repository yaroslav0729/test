<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Order;
use App\Models\Page;
use App\Models\Template;
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
            if ($request->input('RESULT') != '00') {
                if (!empty($order)) {
                    $donations = $order->donations;

                    foreach ($donations as $donation) {
                        $donation->status = Donation::STATUS_CANCELED;
                        $donation->save();
                    }
                }
                die($request->input('MESSAGE'));
            }

            if (!empty($order)) {
                $donations = $order->donations;

                foreach ($donations as $donation) {
                    $donation->status = Donation::STATUS_COMPLETE;
                    $donation->save();
                }

                $this->sendThankYouEmail($order);
            }
            $thanksUrl = Page::getSinglePageUrl(Template::THANK_YOU_DONATE_PAGE);
            $url = url($thanksUrl . '?order=' . $order->order_id);

            Log::debug('GLOBAL PAY: Order id is ' . $order->id);
            return view('pages.global_pay_result', compact('order'));
        }
        Log::debug('GLOBAL PAY: request is empty');
        return view('pages.global_pay_result');
    }
}

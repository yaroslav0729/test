<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GlobalPayController extends Controller
{
    public function result(Request $request)
    {
        Log::info('Global pay request: ' . $request);

        if (!empty($request->input('ORDER_ID'))) {

            $order = Order::where('order_id', $request->input('ORDER_ID'))->first();

            if (!empty($order)) {
                $donations = $order->donations;

                foreach ($donations as $donation) {
                    $donation->status = Donation::STATUS_COMPLETE;
                    $donation->save();
                }
            }
        }

        return view('pages.global_pay_result');
    }

    public function statusUpdate(Request $request)
    {
        Log::info('Global pay status update: ' . $request);

        return response()->json([
            'message' => 'Success Global pay status update page',
            'success' => true,
            'request' => $request->all(),
        ]);
    }
}

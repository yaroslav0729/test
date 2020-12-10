<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Donation;
use App\Models\Template;
use App\Models\Page;

class PaymentController extends Controller
{
    public function paypalPaymentSuccess(Request $request)
    {
        $orderId = $request->get('token');
        $payerID = $request->get('PayerID');

        $order = Order::where('order_id', $orderId)->firstOrFail();

        foreach($order->donations as $donation) {
            $donation->status = Donation::STATUS_COMPLETE;
            $donation->save();
        }

        $thanksUrl = Page::getSinglePageUrl(Template::THANK_YOU_DONATE_PAGE);

        if ($thanksUrl === url('/')) {
            die('Page with template "' . Template::getLabel(Template::THANK_YOU_DONATE_PAGE) . '" is not found.');
        }

        return redirect($thanksUrl);
    }

    public function paypalPaymentCancel(Request $request)
    {
        $orderId = $request->get('token');
        $payerID = $request->get('PayerID');

        dd('order id:' . $orderId . ' canceled');
    }
}

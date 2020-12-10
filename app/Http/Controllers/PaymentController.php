<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Order;
use App\Models\Page;
use App\Models\Template;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\ThankYouDonation;
use App\Models\EmailLog;

class PaymentController extends Controller
{
    public function paypalPaymentSuccess(Request $request)
    {
        $orderId = $request->get('token');
        $payerID = $request->get('PayerID');

        $order = Order::where('order_id', $orderId)->firstOrFail();

        foreach ($order->donations as $donation) {
            $donation->status = Donation::STATUS_COMPLETE;
            $donation->save();
        }

        $thanksUrl = Page::getSinglePageUrl(Template::THANK_YOU_DONATE_PAGE);

        $this->sendThankYouEmail($order);

        if ($thanksUrl === url('/')) {
            die('Page with template "' . Template::getLabel(Template::THANK_YOU_DONATE_PAGE) . '" is not found.');
        }

        return redirect($thanksUrl);
    }

    protected function sendThankYouEmail($order)
    {
        $emailTo = $order->email;
        $subject = 'Thank you for donation';
        $emailFrom = env('MAIL_FROM_ADDRESS');

        Mail::to($emailTo)->send(new ThankYouDonation($order, $subject, $emailTo, $emailFrom));
    }

    public function paypalPaymentCancel(Request $request)
    {
        $orderId = $request->get('token');
        $payerID = $request->get('PayerID');

        $order = Order::where('order_id', $orderId)->firstOrFail();

        foreach ($order->donations as $donation) {
            $donation->status = Donation::STATUS_CANCELED;
            $donation->save();
        }

        die('order id:' . $orderId . ' has been canceled');
    }
}

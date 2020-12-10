<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Mail\ThankYouDonation;
use App\Models\EmailLog;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests; 

    public function test()
    {
        $order = Order::findOrFail(90);

        return view('mail.thank_you_donation', ['order' => $order]);

        $emailTo = $order->email;
        $subject = 'Thank you for donation';
        $emailFrom = env('MAIL_FROM_ADDRESS');

        Mail::to($emailTo)
            ->send(new ThankYouDonation($order, $subject, $emailTo, $emailFrom));

        dd('email send ok');
    }

    
}

<?php

namespace App\Traits;

use App\Mail\ThankYouDonation;
use Illuminate\Support\Facades\Mail;

trait SendThankYouEmail
{
    public function sendThankYouEmail($order)
    {
        $emailTo = $order->email;
        $subject = 'Thank you for donation';
        $emailFrom = env('MAIL_FROM_ADDRESS');

        if (empty($emailTo)) {
            return;
        }

        Mail::to($emailTo)->send(new ThankYouDonation($order, $subject, $emailTo, $emailFrom));
    }
}

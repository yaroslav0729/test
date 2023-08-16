<?php

namespace App\Traits;

use App\Mail\DonationPaid;
use App\Mail\DonationSubscripted;
use App\Mail\ThankYouDonation;
use App\Mail\ThankYouDonationScheduledQurbani;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

trait SendThankYouEmail
{
    public function sendThankYouEmail($order)
    {
        $emailTo = $order->email;
        $subject = 'Thank you for your donation';
        $emailFrom = config('mail.from.address');

        if (empty($emailTo)) {
            return;
        }

        Mail::to($emailTo)->send(new ThankYouDonation($order, $subject, $emailTo, $emailFrom));
    }

    public function sendThankYouScheduledQurbaniEmail($order)
    {
        $emailTo = $order->email;
        $subject = 'Your Qurbani has been Scheduled';
        $emailFrom = config('mail.from.address');

        if (empty($emailTo)) {
            return;
        }

        Mail::to($emailTo)->send(new ThankYouDonationScheduledQurbani($order, $subject, $emailTo, $emailFrom));
    }

    public function sendThankEmailRamadan(Collection $donates, float $sum, int $time): void
    {
        $emailTo = $donates->pluck('email')->first();
        $subject = 'Your Donation (Nights of Mercy)';
        $emailFrom = config('mail.from.address');

        if (empty($emailTo)) {
            return;
        }

        Mail::to($emailTo)
            ->send(
                new DonationPaid($subject, $emailTo, $emailFrom, $sum, Carbon::createFromTimestamp($time), $donates)
            );
    }

    public function sendThankEmailForSubcription(string $email): void
    {
        $emailTo = $email;
        $subject = 'Your Donations have been Automated';
        $emailFrom = config('mail.from.address');

        if (empty($emailTo)) {
            return;
        }

        Mail::to($emailTo)
            ->send(
                new DonationSubscripted($subject, $emailTo, $emailFrom, $subject)
            );
    }
}

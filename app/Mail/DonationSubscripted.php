<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\EmailLog;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DonationSubscripted extends Mailable
{
    use Queueable, SerializesModels;

    private string $startDateSubscription;
    private string $emailTo;
    private string $emailFrom;

    public function __construct(string $subject, string $emailTo, string $emailFrom, string $startDateSubscription)
    {
        $this->startDateSubscription = $startDateSubscription;
        $this->subject = $subject;
        $this->emailTo = $emailTo;
        $this->emailFrom = $emailFrom;
    }

    public function build()
    {
        EmailLog::create([
            'email_to' => $this->emailTo,
            'email_from' => $this->emailFrom,
            'subject' => $this->subject,
            'body' => view('mail.donate.subscripted')
                ->render(),
        ]);

        return $this
            ->from($this->emailFrom)
            ->subject($this->subject)
            ->view('mail.donate.subscripted');
    }
}

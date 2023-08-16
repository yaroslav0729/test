<?php

namespace App\Mail;

use App\Models\EmailLog;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ThankYouDonation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $order;
    public $subject;
    public $emailTo;
    public $emailFrom;

    public function __construct($order, $subject, $emailTo, $emailFrom)
    {
        $this->order = $order;
        $this->subject = $subject;
        $this->emailTo = $emailTo;
        $this->emailFrom = $emailFrom;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        EmailLog::create([
            'email_to' => $this->emailTo,
            'email_from' => $this->emailFrom,
            'subject' => $this->subject,
            'body' => view('mail.thank_you_donation', ['order' => $this->order])->render(),
        ]);

        return $this->from($this->emailFrom)
            ->subject($this->subject)
            ->view('mail.thank_you_donation', ['order' => $this->order]);
    }
}

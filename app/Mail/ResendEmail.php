<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResendEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $body;
    public $subject;
    public $emailFrom;

    public function __construct($emailFrom, $subject, $body)
    {
        $this->body = $body;
        $this->subject = $subject;
        $this->emailFrom = $emailFrom;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->emailFrom)
            ->subject($this->subject)
            ->view('mail.resend', ['body' => $this->body]);
    }
}

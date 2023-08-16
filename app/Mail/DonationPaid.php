<?php

namespace App\Mail;

use App\Models\EmailLog;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class DonationPaid extends Mailable
{
    use Queueable, SerializesModels;

    private string $emailTo;
    private string $emailFrom;
    private float $sum;
    private Carbon $time;
    private Collection $donates;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $subject, string $emailTo, string $emailFrom, float $sum, Carbon $time, Collection $donates)
    {
        $this->subject = $subject;
        $this->emailTo = $emailTo;
        $this->emailFrom = $emailFrom;
        $this->sum = $sum;
        $this->time = $time;
        $this->donates = $donates;
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
            'body' => view('mail.donate.paid', ['sum' => $this->sum / 100, 'created_at' => $this->time, 'donations' => $this->donates])
                ->render(),
        ]);

        return $this
            ->from($this->emailFrom)
            ->subject($this->subject)
            ->view('mail.donate.paid', ['sum' => $this->sum / 100, 'created_at' => $this->time, 'donations' => $this->donates]);
    }
}

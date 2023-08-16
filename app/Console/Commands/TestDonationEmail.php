<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Traits\SendThankYouEmail;
use Illuminate\Console\Command;

class TestDonationEmail extends Command
{
    use SendThankYouEmail;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'donation-email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $order = Order::where('email', 'panchenko_sv@groupbwt.com')->first();
        $this->sendThankYouEmail($order);
    }
}

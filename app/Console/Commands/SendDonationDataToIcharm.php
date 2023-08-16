<?php

namespace App\Console\Commands;

use App\Traits\IcharmData;
use Illuminate\Console\Command;

class SendDonationDataToIcharm extends Command
{
    use IcharmData;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'icharm:send';

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
        $this->checkDonationPingCron();
        return 0;
    }
}

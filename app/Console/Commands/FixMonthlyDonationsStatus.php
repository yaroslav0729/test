<?php

namespace App\Console\Commands;

use App\Models\Donation;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FixMonthlyDonationsStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set "complete" status for last monthly donations';

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
        $donations = Donation::where('created_at', '>=', Carbon::createFromFormat('Y-m-d', '2021-08-28'))->where('created_at', '<=', Carbon::now())->where('status', Donation::STATUS_PROCESSING)->where('type', 20)->get();

        foreach ($donations as $donation) {
            $donation->status = Donation::STATUS_COMPLETE;
            $donation->save();
            $this->info('Updating donation: ' . $donation->id);
        }

        return 0;
    }
}

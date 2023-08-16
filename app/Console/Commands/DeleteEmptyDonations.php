<?php

namespace App\Console\Commands;

use App\Models\Donation;
use Illuminate\Console\Command;

class DeleteEmptyDonations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'donations:delete-empty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete empty donations';

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
        $donations = Donation::whereNull('order_id')->get();

        foreach ($donations as $donation) {
            $this->info('Deleting donation with id ' . $donation->id);
            $donation->delete();
        }

        return 0;
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Donation;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ClearEmptyOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:orders';

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
        $donations = Donation::where('created_at', '>=', Carbon::createFromFormat('Y-m-d', '2021-08-30'))->where('created_at', '<=', Carbon::now())->where('status', Donation::STATUS_PROCESSING)->get();
        $count = count($donations);

        $updatedCount = 0;
        foreach ($donations as $donation) {
            if ($donation->order && $donation->order->order_id) {
                $donation->status = Donation::STATUS_COMPLETE;
                $donation->save();
                $this->info('Updated donation: ' . $donation->id);
                $updatedCount++;
            }
        }
        $this->info("Total donations count: " . $count);
        $this->info('Total updated count: ' . $updatedCount);

        return 0;
    }
}

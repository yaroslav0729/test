<?php

namespace App\Console\Commands;

use App\Models\Donation;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixDonationsDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:donations-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set proper donation date according to order created_at field';

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
        $donations = Donation::where('created_at', '>=', Carbon::createFromFormat('Y-m-d', '2021-08-30')->startOfDay())->where('created_at', '<', Carbon::createFromFormat('Y-m-d', '2021-09-02'))->get();

        $ordersCollection = collect();

        foreach ($donations as $donation) {
            $ordersCollection->push($donation->order);
        }

        $ordersCollection = $ordersCollection->unique();

        foreach ($ordersCollection as $order) {
            $this->info('Order id: ' . $order->id . '; Created at: ' . $order->created_at);
            foreach ($order->donations as $donation) {
                $oldDate = $donation->created_at;
                $donation->created_at = $order->created_at;
                $donation->save();
                $this->info('Donation ' . $donation->id . ' updated. Change date ' . $oldDate . ' to ' . $donation->created_at);
            }
        }

        return 0;
    }
}

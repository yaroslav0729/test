<?php

namespace App\Console\Commands;

use App\Models\Donation;
use App\Models\Order;
use App\Services\Paypal;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CancelBrokenOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel the broken paypal orders';

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
        $this->info('Fetching paypal orders');
        $orders = Order::where('created_at', '>=', Carbon::createFromFormat('Y-m-d', '2021-08-30')->startOfDay())->where('pay_with', 'paypal')->get();

        $canceledCount = 0;
        $donationsCount = 0;

        foreach ($orders as $order) {
            try {
                $this->info('Trying to get paypal order ' . $order->order_id);
                $paypalOrder = Paypal::getOrder($order->order_id);
                $this->info('Order ' . $order->order_id . ' is paid');
            } catch (Exception $e) {
                $this->info('Order ' . $order->order_id . ' is cancelled');
                $canceledCount++;
                $donations = $order->donations;
                foreach ($donations as $donation) {
                    $this->info('Set status ' . Donation::STATUS_CANCELED . ' to donation ' . $donation->id);
                    $this->info('Donation time ' . $donation->created_at);
                    $donation->status = Donation::STATUS_CANCELED;
                    $donation->save();
                    $donationsCount++;
                }
            }
            sleep(1);
        }

        $this->info('Total donation set to cancelled ' . $donationsCount);
        $this->info('Total cancelled count: ' . $canceledCount);

        return 0;
    }
}

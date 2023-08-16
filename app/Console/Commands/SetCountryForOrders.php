<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SetCountryForOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:country';

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
        $orders = Order::where('created_at', '>=', Carbon::createFromFormat('Y-m-d', '2021-08-30'))->get();

        foreach ($orders as $order) {
            if (empty($order->order_id)) {
                $this->info('Order ' . $order->id . ' havent an order id');
                $orderId = hash('sha1', Str::random(10) . 'monthly');
                $this->info('UPDATE: set ' . $orderId . ' for order ' . $order->id);
                $order->order_id = $orderId;
            }
            $countryId = intval($order->country);
            if ($countryId) {
                $country = Country::find($countryId);

                if ($country) {
                    $order->country = $country->name;
                    $this->info('Update order country from ' . $countryId . ' to ' . $country->name);
                }
            }

            $order->save();
        }

        return 0;
    }
}

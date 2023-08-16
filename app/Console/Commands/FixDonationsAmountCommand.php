<?php

namespace App\Console\Commands;

use App\Models\Donation;
use DB;
use Illuminate\Console\Command;

class FixDonationsAmountCommand extends Command
{
    protected $signature = 'fix-donates:amount';

    protected $description = 'Fix donations amount';

    private $wpConnection;

    public function handle()
    {
        $this->wpConnection = DB::connection('wp');
        $this->fixDonations();
    }

    public function fixDonations()
    {
        $donations = Donation::whereNotNull('wp_id')->get();

        $wpIds = $donations->pluck('wp_id')->toArray();

        $searchAll = $this->wpConnection->table('donate_items')->join('donate_orders', 'donate_items.order_id', '=', 'donate_orders.id')
            ->selectRaw('SUM(amount) AS total_amount, donate_orders.email, donate_items.order_id')->whereIn('donate_items.order_id', $wpIds)->groupBy('donate_orders.email', 'donate_items.order_id')->get();

        foreach ($donations as $donation)
        {
            $search = $searchAll
                ->where('order_id', $donation->wp_id)
                ->where('email', $donation->email)->first();

            if ($search)
            {
                if (round($search->total_amount, 2) !== $donation->value)
                {
                    if (strpos(strtolower($search->total_amount), 'e') === false && is_numeric($search->total_amount) && $search->total_amount < 1000000) {
                        $this->info('ID - ' . $donation->wp_id . ' | OLD AMOUNT - ' . $donation->value . ' | NEW AMOUNT - ' .  round($search->total_amount, 2));
                        $donation->value = round($search->total_amount, 2);
                        $donation->save();

                        $donation->replicate()
                            ->setTable('donations2')
                            ->save();
                    }
                }
            }
        }
    }
}

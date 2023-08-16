<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CartItem;
use Carbon\Carbon;

class ClearCartItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan clear:cart
     * 
     * @var string
     */
    protected $signature = 'clear:cart';

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
        $this->info('Clear cart command started');

        CartItem::where('created_at', '<', Carbon::now()->subDays(3)->toDateTimeString())->delete();

        $this->info('Clear cart command complete!');
    }
}

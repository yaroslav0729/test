<?php

namespace App\Console\Commands;

use App\Models\MenuItem;
use Illuminate\Console\Command;

class ResolveNullOrdering extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resolve-null-ordering';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setting default ordering for items with nullable ordering';

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
        MenuItem::whereNull('ordering')->get()->each(function (MenuItem $menuItem) {
            $menuItem->setNewOrder([$menuItem->id], $menuItem->getHighestOrderNumber() + 1);
        });

        return 0;
    }
}

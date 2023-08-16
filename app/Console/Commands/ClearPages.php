<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Page;

class ClearPages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan clear:pages
     * 
     * @var string
     */
    protected $signature = 'clear:pages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove pages without active page instances';

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
        $this->info('Clear command started');

        $pages = Page::doesntHave('pageInstances')->get();
        $count = count($pages);

        foreach ($pages as $page) {
            if ($page->event) {
                $page->event()->delete();    
            }
        }

        Page::doesntHave('pageInstances')->delete();

        $this->info('Command complete. Deleted: ' . $count . ' pages');
    }
}

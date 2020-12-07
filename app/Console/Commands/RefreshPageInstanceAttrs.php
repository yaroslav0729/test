<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PageInstance;
use App\Models\Template;


class RefreshPageInstanceAttrs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan refresh:page_attributes
     * 
     * @var string
     */
    protected $signature = 'refresh:page_attributes';

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
        $this->info('command started');

        $pageInstances = PageInstance::where('template', Template::PROJECT_PAGE)->get();
        
        foreach ($pageInstances as $pageInstance) {

            $pageInstance->refreshParams();

            $this->info('Page instance id: ' . $pageInstance->id . ' refreshed');
        }

        $this->info('command complete');
    }
}

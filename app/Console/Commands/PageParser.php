<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Log;
use App\Models\Campaign;
use \App\Models\Country;
use \App\Models\CampaignPrice;
use Carbon\Carbon;
use App\Models\CampaignCategory;

class PageParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan parse:page
     * 
     * @var string
     */
    protected $signature = 'parse:page';

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
        $this->info('Pages parser command started.');
        $this->wpConnection = DB::connection('wp');



        $this->info('Parsing complete!');
    }

    protected function parseProjects()
    {
        $posts = $this->wpConnection->table('wp_posts')
                        ->join('wp_postmeta', 'wp_posts.id', '=', 'wp_postmeta.post_id')
                        ->where('wp_posts.post_type', 'page')
                        ->where('wp_postmeta.meta_value', 'template/projectpage5prices.php')
                        ->orWhere('wp_postmeta.meta_value', 'template/projectpage2020.php')
                        ->get();
        
        $this->logPosts($posts, 'Projects ids: ');
        
        $this->info('count posts:' . count($posts));
    }
}

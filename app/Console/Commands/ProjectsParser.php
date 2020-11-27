<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class ProjectsParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan parse:projects
     * 
     * @var string
     */
    protected $signature = 'parse:projects';

    protected $wpConnection;

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
        $this->info('Parse projects command started.');
        
        $this->wpConnection = DB::connection('wp');

        $posts = $this->wpConnection->table('wp_posts')
                        ->where('post_type', 'campaigns')->get();

        // foreach ($posts as $post) {
        //     #code
        // }

        $this->info('count posts:' . count($posts));

        $this->info('Parsing complete!');
    }
}

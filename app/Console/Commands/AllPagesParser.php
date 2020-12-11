<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class AllPagesParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan parse:all_pages
     * 
     * @var string
     */
    protected $signature = 'parse:all_pages';

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
        $this->info('All pages parser command started.');
        $this->wpConnection = DB::connection('wp');

        $this->parseAllPages();

        $this->info('Parsing complete!');
    }

    protected function parseAllPages()
    {
        $this->getAllTemplates();
    }

    protected function getAllTemplates()
    {
        $posts = $this->wpConnection->table('wp_posts')
            ->join('wp_postmeta', 'wp_posts.id', '=', 'wp_postmeta.post_id')
            ->where('wp_posts.post_type', 'page')
            ->where(function ($query) {
                $query->where('wp_postmeta.meta_key', '_wp_page_template');
            })
            ->get();

        $allTemplates = [];

        foreach ($posts as $post) {
            $allTemplates[] = $post->meta_value;
        }
        $allTemplates = array_unique($allTemplates);

        dd($allTemplates);
    }
}

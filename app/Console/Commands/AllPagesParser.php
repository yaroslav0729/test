<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Console\Commands\Parts\ProjectsParser;

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

    protected $posts;
    protected $templates;
    protected $sortedPosts;

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

        $this->getAllPostsWithTemplate();
        $this->getAllTemplates();
        $countPages = $this->getCountOfPages();
        $this->sortPosts();

        dump($countPages);

        $this->parseProjects();

        $this->info('Parsing complete!');
    }

    protected function parseProjects()
    {
        $this->info('Projects parser:');

        $projectsParser = new ProjectsParser($this->wpConnection);

        $projectsParser->parseProjects($this->sortedPosts['template/projectpage5prices.php']);
        $projectsParser->parseProjects($this->sortedPosts['template/projectpage2020.php']);
    }

    protected function sortPosts()
    {
        $this->sortedPosts = [];

        foreach ($this->posts as $post) {
            $templateName = $post->meta_value;
            $this->sortedPosts[$templateName][] = $post;
        }
    }

    public function getCountOfPages()
    {
        $allTemplates = [];

        foreach ($this->posts as $post) {
            $allTemplates[] = $post->meta_value;
        }

        return array_count_values($allTemplates);
    }

    protected function getAllPostsWithTemplate()
    {
        $posts = $this->wpConnection->table('wp_posts')
            ->join('wp_postmeta', 'wp_posts.id', '=', 'wp_postmeta.post_id')
            ->where('wp_posts.post_type', 'page')
            ->where(function ($query) {
                $query->where('wp_postmeta.meta_key', '_wp_page_template');
            })
            ->get();

        $this->posts = $posts;
    }

    protected function getAllTemplates()
    {
        $allTemplates = [];

        foreach ($this->posts as $post) {
            $allTemplates[] = $post->meta_value;
        }

        $this->templates = array_unique($allTemplates);
    }
}

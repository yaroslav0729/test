<?php

namespace App\Console\Commands;

use App\Console\Commands\Parts\EventsParser;
use App\Console\Commands\Parts\MediaParser;
use App\Console\Commands\Parts\ProjectsParser;
use DB;
use Illuminate\Console\Command;

class AllPagesParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan parse:all_pages
     * php artisan parse:all_pages --parser=projects
     * php artisan parse:all_pages --parser=media
     * php artisan parse:all_pages --parser=events
     *
     * @var string
     */
    protected $signature = 'parse:all_pages {--parser=}';

    /*

    parser option: media, projects, events

     */

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
        $parserOption = $this->option('parser');

        $this->info('All pages parser command started.');
        $this->wpConnection = DB::connection('wp');

        if (($parserOption === 'projects') || (!$parserOption)) {
            $this->parseProjects();
        }
        if (($parserOption === 'events') || (!$parserOption)) {
            $this->parseEvents();
        }
        if (($parserOption === 'media') || (!$parserOption)) {
            $this->parseMedia();
        }

        $this->info('Parsing complete!');
    }

    protected function parseProjects()
    {
        $this->info('Projects parser:');

        $projectsParser = new ProjectsParser($this->wpConnection);

        $projectsParser->parse();
    }

    protected function parseEvents()
    {
        $this->info('Events parser:');

        $eventsParser = new EventsParser($this->wpConnection);

        $eventsParser->parse();
    }

    protected function parseMedia()
    {
        $this->info('Media parser:');

        $mediaParser = new MediaParser();

        $mediaParser->parse();
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

        $allTemplates = array_count_values($allTemplates);

        dump($allTemplates);
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

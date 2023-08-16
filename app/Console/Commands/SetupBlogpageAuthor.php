<?php

namespace App\Console\Commands;

use App\Models\PageInstance;
use App\Models\Template;
use Illuminate\Console\Command;

class SetupBlogpageAuthor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog-page:author {--id=} {author=ISLAMIC HELP}';

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
        $author = $this->argument('author');
        $blogPages = PageInstance::where('template', Template::BLOG_PAGE)->get();

        foreach ($blogPages as $page) {
            $parameters = $page->parameters;
            $parameters['written_by'] = $author;
            $page->update(['parameters' => $parameters]);
        }

        return 0;
    }
}

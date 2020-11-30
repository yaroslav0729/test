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
use App\Models\Page;
use App\Models\PageInstance;
use App\Models\Template;

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

        $this->parseProjects();

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

        foreach ($posts as $pageKey => $project) {

            $copyProject = Page::where('wp_id', $project->ID)->first();

            if ($copyProject) {

                $copyProjectInstance = $copyProject->actual_page_instance;

                if (!isset($copyProjectInstance)) {
                    dd($copyProject->id);
                }
                
                $copyProjectInstance->update([
                    'name' => $project->post_title,
                    'slug' => $project->post_name,
                    'title' => $project->post_title,
                    'description' => 'parsed project page wp_id: ' . $project->ID,
                    'template' => Template::PROJECT_PAGE,
                ]);

                $infoString = $pageKey . ': Project updated => id: ' . $copyProject->id . ', wp_id: ' . $copyProject->wp_id;

            } else {

                $copyProject = Page::create([
                    'wp_id' => $project->ID,
                    'status' => Page::PAGE_STATUS_PUBLICHED
                ]);

                $copyProjectInstance = PageInstance::create([
                    'name' => $project->post_title,
                    'slug' => $project->post_name,
                    'title' => $project->post_title,
                    'description' => 'parsed project page wp_id: ' . $project->ID,
                    'page_id' => $copyProject->id,
                    'template' => Template::PROJECT_PAGE,
                ]);

                $copyProjectInstance->actual = true;
                $copyProjectInstance->save();

                $infoString = $pageKey . ': Project created => id: ' . $copyProject->id . ', wp_id: ' . $copyProject->wp_id;
            }

            $this->info($infoString);
            Log::channel('parser')->info($infoString);
        }


        $this->info('count posts:' . count($posts));
    }
}

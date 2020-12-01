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
                        //->where('ID', 18219)
                        ->join('wp_postmeta', 'wp_posts.id', '=', 'wp_postmeta.post_id')
                        ->where('wp_posts.post_type', 'page')
                        ->where(function($query) {
                            $query->where('wp_postmeta.meta_value', 'template/projectpage5prices.php')
                            ->orWhere('wp_postmeta.meta_value', 'template/projectpage2020.php');
                        })
                        ->get();

        foreach ($posts as $pageKey => $project) {

            $copyProject = Page::where('wp_id', $project->ID)->first();

            $projectOptions =  $this->wpConnection->table('wp_postmeta')
                                ->where('post_id', $project->ID)
                                ->get();

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

            $this->updateProjectPrices($copyProjectInstance, $projectOptions);

            $this->info($infoString);
            Log::channel('parser')->info($infoString);
        }


        $this->info('count posts:' . count($posts));
    }

    protected function updateProjectPrices($projectInstance, $projectOptions)
    {
        $amount = [];

        foreach ($projectOptions as $option) {

            $priceType = null;
            if (strpos($option->meta_key, '_single_price')!== false) {
                $priceType = CampaignPrice::TYPE_SINGLE;  
            }
            if (strpos($option->meta_key, '_month_price')!== false) {
                $priceType = CampaignPrice::TYPE_MONTHLY;  
            }

            if ((isset($priceType)) && (intval($option->meta_value) !== 0)) {

                $priceText = $this->searchPriceText($projectOptions, $priceType, $option->meta_key);
                
                $amount[] = [
                    'value' => $option->meta_value,
                    'type' => $priceType,
                    'text' => $priceText,
                    'campaigns' => []
                ];

            
                $typeStr = $priceType === CampaignPrice::TYPE_SINGLE ? 'single' : 'monthly';
                $infoString = 'project price created => value: ' . $option->meta_value . ', type: ' . $typeStr;
                
                //$this->info($infoString);
                Log::channel('parser')->info($infoString);
            }
        }

        if (count($amount)) {
            $parameters = $projectInstance->parameters;
            $parameters['amount'] = $amount;
            $projectInstance->parameters = $parameters;
            $projectInstance->save();
        }
    }

    protected function searchPriceText($projectOptions, $priceType, $keyStr)
    {
        $keyArr = explode('_', $keyStr);

        if (isset($keyArr[1])) {

            $key = intval($keyArr[1]);

            if (($key === 0) && ($keyArr[1] !== '0')) return "";

            $type = $priceType === CampaignPrice::TYPE_SINGLE ? 'single' : 'month';

            $metaKey = 'donation_' . $key . '_' . $type . '_donation_' . $key . '_' . $type . '_text';

            foreach ($projectOptions as $option) {
                if ($option->meta_key === $metaKey) {
                    return $option->meta_value;
                }
            }

            return "";

        } else {
            return "";
        }
    }
}

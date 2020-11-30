<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Log;
use App\Models\Campaign;
use \App\Models\Country;
use Carbon\Carbon;

class ProjectsParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan parse:projects
     * php artisan parse:projects --campaigns
     * 
     * @var string
     */
    protected $signature = 'parse:projects {--campaigns}';

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

        $campaignsOption = $this->option('campaigns');
        
        $this->wpConnection = DB::connection('wp');

        if ($campaignsOption) {
            $this->parseCampaigns();
            $this->parseEmergencyCampaigns();
        } else {
            $this->parseProjects();
        }

        $this->info('Parsing complete!');
    }

    protected function parseEmergencyCampaigns($emergency = false)
    {
        return $this->parseCampaigns(true);
    }


    protected function parseCampaigns($emergency = false)
    {
        if ($emergency) {
            $table = 'emergency-campaigns';
        } else {
            $table = 'campaigns';
        }

        $campaigns = $this->wpConnection->table('wp_posts')
                        ->where('post_type', $table)->get();

        $this->logPosts($campaigns, 'Campaigns ids: ');

        foreach ($campaigns as $campKey => $campaign) {
            $campaignOptions =  $this->wpConnection->table('wp_postmeta')
                                ->where('post_id', $campaign->ID)
                                ->get();
                                
            $campaigns[$campKey]->meta_start_date = $this->getOptionByName($campaignOptions, 'cpg_start_day');
            $campaigns[$campKey]->meta_end_date = $this->getOptionByName($campaignOptions, 'cpg_end_day');
            $campaigns[$campKey]->meta_country = $this->getOptionByName($campaignOptions, 'campaign_country');

            if ((!empty($campaigns[$campKey]->meta_start_date)) && 
                (!empty($campaigns[$campKey]->meta_end_date))) {

                $copyCampaign = Campaign::where('wp_id', $campaign->ID)->first();

                if ($copyCampaign) {
                    $copyCampaign->update([
                        'name' => $campaign->post_title,
                        'description' => 'parsed campaign wp_id: ' . $campaign->ID,
                        'start_date' => $this->formatDate($campaigns[$campKey]->meta_start_date),
                        'end_date' => $this->formatDate($campaigns[$campKey]->meta_end_date),
                        'country_id' => $this->getCountryId($campaigns[$campKey]->meta_country),
                        'is_emergency' => $emergency
                    ]);

                    $infoString = $campKey . ': Campaign updated => id: ' . $copyCampaign->id . ', wp_id: ' . $copyCampaign->wp_id;
                } else {
                    $copyCampaign = Campaign::create([
                        'name' => $campaign->post_title,
                        'description' => 'parsed campaign wp_id: ' . $campaign->ID,
                        'start_date' => $this->formatDate($campaigns[$campKey]->meta_start_date),
                        'end_date' => $this->formatDate($campaigns[$campKey]->meta_end_date),
                        'country_id' => $this->getCountryId($campaigns[$campKey]->meta_country),
                        'wp_id' => $campaign->ID,
                        'is_emergency' => $emergency
                    ]);

                    $infoString = $campKey . ': New campaign created => id: ' . $copyCampaign->id . ', wp_id: ' . $copyCampaign->wp_id;
                }

                
                $this->info($infoString);
                Log::channel('parser')->info($infoString);
            }
        }

        $this->info('count posts:' . count($campaigns));
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

    protected function formatDate($date)
    {
        if (strlen($date) === 8) {
            $year = substr($date, 0, 4);
            $month = substr($date, 4, 2);
            $day = substr($date, 6, 2);

            $date = new Carbon($year . '-' . $month . '-' . $day);
        } else {
            return null;
        }

        return $date;
    }

    protected function getCountryId($country)
    {
        $country = Country::where('name', $country)->first();
        if (isset($country)) return $country->id;
        else return null;
    }

    protected function getOptionByName($options, $optName) 
    {
        foreach ($options as $option) {
            if ($option->meta_key === $optName) {
                return $option->meta_value;
            }
        }

        return null;
    }

    protected function logPosts($posts, $infoString) {
        $ids = [];

        foreach ($posts as $post) {
            $ids[] = $post->ID;
        }    

        Log::channel('parser')->info($infoString . '[' . implode(', ', $ids) . ']');  
    }
}

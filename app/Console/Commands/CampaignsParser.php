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

class CampaignsParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan parse:campaigns
     * 
     * @var string
     */
    protected $signature = 'parse:campaigns';

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
        $this->info('Campaigns parser command started.');
        $this->wpConnection = DB::connection('wp');

        $this->parseCampaigns();
        $this->info('//--- emergency projects ---');
        $this->parseEmergencyCampaigns();

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

        foreach ($campaigns as $campKey => $campaign) {
            $campaignOptions =  $this->wpConnection->table('wp_postmeta')
                ->where('post_id', $campaign->ID)
                ->get();

            $campaigns[$campKey]->meta_start_date = $this->getOptionByName($campaignOptions, 'cpg_start_day');
            $campaigns[$campKey]->meta_end_date = $this->getOptionByName($campaignOptions, 'cpg_end_day');
            $campaigns[$campKey]->meta_country = $this->getOptionByName($campaignOptions, 'campaign_country');

            if ((!empty($campaigns[$campKey]->meta_start_date)) &&
                (!empty($campaigns[$campKey]->meta_end_date))
            ) {

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
                    $this->updateCampaignPrices($copyCampaign, $campaignOptions);
                    $this->updateCampaignCategories($copyCampaign);
                    $this->info($infoString);
                    Log::channel('parser')->info($infoString);
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
                    $this->updateCampaignPrices($copyCampaign, $campaignOptions);
                    $this->updateCampaignCategories($copyCampaign);
                    $this->info($infoString);
                    Log::channel('parser')->info($infoString);
                }
            }
        }

        $this->info('count posts:' . count($campaigns));
    }



    protected function updateCampaignCategories($campaign)
    {
        $wpCategories = $this->wpConnection->table('wp_term_relationships')
            ->where('object_id', $campaign->wp_id)
            ->join('wp_term_taxonomy', 'wp_term_relationships.term_taxonomy_id', '=', 'wp_term_taxonomy.term_taxonomy_id')
            ->join('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
            ->select('wp_terms.name')
            ->get();

        $wpNames = [];
        foreach ($wpCategories as $wpCategory) {
            $wpNames[] = $wpCategory->name;
        }

        $categories = CampaignCategory::whereIn('name', $wpNames)->get();

        $campaign->campaign_categories()->detach();
        $campaign->campaign_categories()->attach($categories);
        $campaign->save();

        $infoString = 'Update campaign categories: [' . implode(', ', $wpNames) . ']';
        $this->info($infoString);
        Log::channel('parser')->info($infoString);
    }

    protected function updateCampaignPrices($campaign, $campaignOptions)
    {
        CampaignPrice::where('campaign_id', $campaign->id)->delete();

        foreach ($campaignOptions as $option) {

            $priceType = null;
            if (strpos($option->meta_key, 'prices_single_') !== false) {
                $priceType = CampaignPrice::TYPE_SINGLE;
            }
            if (strpos($option->meta_key, 'prices_monthly_') !== false) {
                $priceType = CampaignPrice::TYPE_MONTHLY;
            }

            if ((isset($priceType)) && (intval($option->meta_value) !== 0)) {

                CampaignPrice::create([
                    'value' => $option->meta_value,
                    'type' => $priceType,
                    'campaign_id' => $campaign->id
                ]);

                $typeStr = $priceType === CampaignPrice::TYPE_SINGLE ? 'single' : 'monthly';
                $infoString = 'price created => value: ' . $option->meta_value . ', type: ' . $typeStr;

                //$this->info($infoString);
                Log::channel('parser')->info($infoString);
            }
        }
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
}

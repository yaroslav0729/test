<?php

namespace App\Console\Commands\Parts;

use App\Console\Commands\Parts\AbstractParser;
use App\Models\Campaign;
use App\Models\Page;
use App\Models\PageInstance;
use App\Models\Template;
use Illuminate\Support\Facades\Log;
use \App\Models\CampaignPrice;

class ProjectsParser extends AbstractParser
{
    const IMG_PATH = 'projects';

    public function parse()
    {
        $posts = $this->wpConnection->table('wp_posts')
            ->join('wp_postmeta', 'wp_posts.id', '=', 'wp_postmeta.post_id')
            ->where('wp_posts.post_type', 'page')
            ->where('wp_posts.post_status', 'publish')
            ->where(function ($query) {
                $query->where('wp_postmeta.meta_value', 'template/projectpage5prices.php')
                    ->orWhere('wp_postmeta.meta_value', 'template/projectpage2020.php');
            })
            ->get();

        foreach ($posts as $pageKey => $project) {

            $copyProject = Page::where('wp_id', $project->ID)->first();

            $projectOptions = $this->wpConnection->table('wp_postmeta')
                ->where('post_id', $project->ID)
                ->get();

            if ($copyProject) {

                $copyProjectInstance = $copyProject->actual_page_instance;

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
                    'status' => Page::PAGE_STATUS_PUBLISHED,
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
            $this->updateProjectTemplateParams($copyProjectInstance, $projectOptions);

            $this->info($infoString);
            Log::channel('parser')->info($infoString);
        }

        $this->info('count posts:' . count($posts));
    }

    protected function updateProjectTemplateParams($projectInstance, $projectOptions)
    {
        $parameters = $projectInstance->parameters;

        $parameters['donate_text'] = $this->getOption($projectOptions, 'featured_image_text');

        $parameters['still_need_digit1'] = $this->getOption($projectOptions, 'donation_boxes_0_donate_today_0_donate_price');
        $parameters['still_need_digit2'] = $this->getOption($projectOptions, 'donation_boxes_0_donate_today_1_donate_price');
        $parameters['still_need_digit3'] = $this->getOption($projectOptions, 'donation_boxes_0_donate_today_2_donate_price');

        $parameters['still_need_text1'] = $this->getOption($projectOptions, 'donation_boxes_0_donate_today_0_donate_text');
        $parameters['still_need_text2'] = $this->getOption($projectOptions, 'donation_boxes_0_donate_today_1_donate_text');
        $parameters['still_need_text3'] = $this->getOption($projectOptions, 'donation_boxes_0_donate_today_2_donate_text');

        $parameters['proj_heading'] = $this->getOption($projectOptions, 'heading');

        $hdr1 = $this->getOption($projectOptions, 'pro_heading_1');
        $hdr2 = $this->getOption($projectOptions, 'pro_heading_2');
        $hdr3 = $this->getOption($projectOptions, 'pro_heading_3');
        $p1 = $this->getOption($projectOptions, 'pro_paragraph_1');
        $p2 = $this->getOption($projectOptions, 'pro_paragraph_2');
        $p3 = $this->getOption($projectOptions, 'pro_paragraph_3');
        $videoLink = $this->getOption($projectOptions, 'pro_video_id');

        $hdr1 = "<h2>$hdr1</h2>";
        $hdr2 = "<h2>$hdr2</h2>";
        $hdr3 = "<h2>$hdr3</h2>";
        $p1 = "<p>$p1</p>";
        $p2 = "<p>$p2</p>";
        $p3 = "<p>$p3</p>";
        $videoLink = "{video-carousel|$videoLink}";
        $mainHtml = $hdr1 . $p1 . $hdr2 . $p2 . $videoLink . $hdr3 . $p3;

        $parameters['main_html'] = $mainHtml;

        $parameters['important_title'] = $this->getOption($projectOptions, 'cta_heading'); // mobile - cta_mobile_heading
        $parameters['important_text'] = $this->getOption($projectOptions, 'cta_detail_text'); // mobile - cta_mobile_detail_text
        $parameters['what_happens_title'] = $this->getOption($projectOptions, 'ih_help_result_heading'); // mobile - cta_mobile_detail_text
        $parameters['what_happens_text'] = $this->getOption($projectOptions, 'ih_help_result_text'); // mobile - cta_mobile_detail_text

        $parameters['what_happens_block1_title'] = $this->getOption($projectOptions, 'counter_box_1_value');
        $parameters['what_happens_block2_title'] = $this->getOption($projectOptions, 'counter_box_2_value');
        $parameters['what_happens_block3_title'] = $this->getOption($projectOptions, 'counter_box_3_value');

        $parameters['what_happens_block1_text'] = $this->getOption($projectOptions, 'counter_box_1_text');
        $parameters['what_happens_block2_text'] = $this->getOption($projectOptions, 'counter_box_2_text');
        $parameters['what_happens_block3_text'] = $this->getOption($projectOptions, 'counter_box_3_text');

        $featuredImageId = $this->getOption($projectOptions, 'featured_image');
        $parameters['donate_img'] = $this->getWpImage($featuredImageId);

        $whatHappensImage = $this->getOption($projectOptions, 'ih_help_result_image');
        $parameters['what_happens_img'] = $this->getWpImage($whatHappensImage);

        $projectInstance->parameters = $parameters;
        $projectInstance->title = $this->getOption($projectOptions, '_yoast_wpseo_title');
        $projectInstance->description = $this->getOption($projectOptions, '_yoast_wpseo_metadesc');
        $projectInstance->preview_img = $parameters['donate_img'];
        $projectInstance->save();
    }

    protected function updateProjectPrices($projectInstance, $projectOptions)
    {
        $amount = [];

        foreach ($projectOptions as $option) {

            $priceType = null;
            if (strpos($option->meta_key, '_single_price') !== false) {
                $priceType = CampaignPrice::TYPE_SINGLE;
            }
            if (strpos($option->meta_key, '_month_price') !== false) {
                $priceType = CampaignPrice::TYPE_MONTHLY;
            }

            if ((isset($priceType)) && (intval($option->meta_value) !== 0)) {

                $priceKey = $this->searchKey($option->meta_key);
                $priceText = "";
                $priceCampaigns = [];

                if (isset($priceKey)) {
                    $priceText = $this->searchPriceText($projectOptions, $priceType, $priceKey);
                    $priceCampaigns = $this->searchPriceCampaigns($projectOptions, $priceType, $priceKey);
                }

                $amount[] = [
                    'value' => $option->meta_value,
                    'type' => $priceType,
                    'text' => $priceText,
                    'campaigns' => $priceCampaigns,
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

    protected function searchKey($keyStr)
    {
        $keyArr = explode('_', $keyStr);

        if (isset($keyArr[4])) {

            $key = intval($keyArr[4]);

            if (($key === 0) && ($keyArr[4] !== '0')) {
                return null;
            }

            return $key;
        }

        return null;
    }

    protected function searchPriceCampaigns($projectOptions, $priceType, $key)
    {
        $type1 = $priceType === CampaignPrice::TYPE_SINGLE ? 'single' : 'monthly';
        $type2 = $priceType === CampaignPrice::TYPE_SINGLE ? 'single' : 'mobthly'; // mobthly - mistake in WP key

        $keyPattern1 = 'donation_0_' . $type1 . '_donation_' . $key . '_' . $type2 . 'add_campaign_countries_';
        $keyPattern2 = $type1 . 'campaign_id';
        $keyPattern3 = '#donate-';

        $keyPattern4 = 'donation_0_' . $type1 . '_donation_' . $key . '_' . $type1 . '_popup_url_id';

        $campaignsMeta = [];

        foreach ($projectOptions as $option) {
            $metaKey = $option->meta_key;
            $metaValue = $option->meta_value;

            if ((strpos($metaKey, $keyPattern1) === 0) &&
                (strpos($metaKey, $keyPattern2)) &&
                (strpos($metaValue, $keyPattern3)) !== false) {

                $pos = strpos($metaValue, $keyPattern3);
                $campaignsMeta[] = substr($metaValue, $pos + 8);
            }

            if ((strpos($metaKey, $keyPattern4) === 0) &&
                (strpos($metaValue, $keyPattern3)) !== false) {

                $pos = strpos($metaValue, $keyPattern3);
                $campaignsMeta[] = substr($metaValue, $pos + 8);
            }
        }

        $campaigns = Campaign::whereIn('wp_id', $campaignsMeta)->pluck('id');

        return $campaigns;
    }

    protected function searchPriceText($projectOptions, $priceType, $key)
    {
        $type1 = $priceType === CampaignPrice::TYPE_SINGLE ? 'single' : 'month';
        $type2 = $priceType === CampaignPrice::TYPE_SINGLE ? 'single' : 'monthly';

        $metaKey = 'donation_0_' . $type2 . '_donation_' . $key . '_' . $type1 . '_text';

        foreach ($projectOptions as $option) {
            if ($option->meta_key === $metaKey) {
                return $option->meta_value;
            }
        }

        return "";
    }
}

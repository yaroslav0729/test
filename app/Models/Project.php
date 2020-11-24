<?php

namespace App\Models;

use \App\Models\Page;
use \App\Models\Template;
use \App\Models\CampaignPrice;
use \App\Models\Campaign;
use Illuminate\Database\Eloquent\Builder;

class Project
{
    public static function getAllProjects()
    {
        $pages = \App\Models\Page::whereHas('pageInstances', function (Builder $query) {
            $query->where('template', Template::PROJECT_PAGE);
        })->get();

        return $pages;
    }

    public static function getSingleProjects()
    {
        return self::getFilteredProjects(CampaignPrice::TYPE_SINGLE);
    }

    public static function getMonthlyProjects()
    {
        return self::getFilteredProjects(CampaignPrice::TYPE_MONTHLY);
    }

    public static function getAppealProjects()
    {
        $pages = self::getAllProjects();
        $parameters = [];
        $test = [];

        $collectedPages = [];

        foreach ($pages as $page) {
            $pInstance = $page->actual_page_instance;
            $parameters = $pInstance->parameters;

            if (isset($parameters['amount'])) {
                foreach ($parameters['amount'] as $price) {
                    if (isset($price['campaigns'])) {
                        $campaigns = Campaign::whereIn('id', $price['campaigns'])->emergency()->get();
                        if (count($campaigns)) {
                            $collectedPages[] = $page;
                            break;
                        }
                        
                    }
                }
            }
        }

        return $collectedPages;   
    }

    protected static function getFilteredProjects($projType)
    {
        $pages = self::getAllProjects();
        $parameters = [];
        $test = [];

        $collectedPages = [];

        foreach ($pages as $page) {
            $pInstance = $page->actual_page_instance;
            $parameters = $pInstance->parameters;

            if (isset($parameters['amount'])) {
                foreach ($parameters['amount'] as $price) {
                    if ((isset($price['type'])) && ((int)$price['type'] === $projType)) {
                        $collectedPages[] = $page;
                        break;
                    }
                }
            }
        }

        return $collectedPages;
    }

    protected static function isPriceExists($campId, $value, $type)
    {
        $count = Campaign::where('id', $campId)->active()->
                whereHas('campaign_prices', function ($q) use ($value, $type) {
                    $q->where('value', $value)
                    ->where('type', $type);
                })->count();

        if ($count) {
            return true;
        } else {
            return false;
        }
    }

    public static function getSinglePrices($project)
    {
        $pageInstance = $project->actual_page_instance;

        $amount = [];

        if (isset($pageInstance->parameters['amount'])) {
            $amount = $pageInstance->parameters['amount'];  
        }

        $prices = [];
        foreach ($amount as $price) {
            if ((isset($price['type'])) && ((int)$price['type'] === \App\Models\CampaignPrice::TYPE_SINGLE)) {
                
                if (isset($price['campaigns'])) {
                    foreach ($price['campaigns'] as $campaignId) {
                        
                        $priceExists = self::isPriceExists($campaignId, $price['value'], $price['type']);

                        if ($priceExists) {
                            $prices[] =  $price['value'];
                            break;
                        }
                        
                    }
                }
                
                
            }
        }

        //~~~ check prices in campaigns

        return $prices;
    }

    public static function getMonthlyPrices($project)
    {
        $pageInstance = $project->actual_page_instance;

        $amount = [];

        if (isset($pageInstance->parameters['amount'])) {
            $amount = $pageInstance->parameters['amount'];  
        }

        $prices = [];
        foreach ($amount as $price) {
            if ((isset($price['type'])) && ((int)$price['type'] === \App\Models\CampaignPrice::TYPE_MONTHLY)) {
                if (isset($price['campaigns'])) {
                    foreach ($price['campaigns'] as $campaignId) {
                        
                        $priceExists = self::isPriceExists($campaignId, $price['value'], $price['type']);

                        if ($priceExists) {
                            $prices[] =  $price['value'];
                            break;
                        }
                        
                    }
                }
            }
        }

        return $prices;
    }
}
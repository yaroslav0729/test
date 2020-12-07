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
        $pages = Page::whereHas('pageInstances', function (Builder $query) {
            $query->where('template', Template::PROJECT_PAGE);
        })->published()->get();

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

    public static function getProjectCampaignsCateg($pageInstance)
    {
        $amount = [];

        if (isset($pageInstance->parameters['amount'])) {
            $amount = $pageInstance->parameters['amount'];  
        }

        $campaignsNames = [];

        foreach ($amount as $price) {
            if (isset($price['type'])) {
                
                if (isset($price['campaigns'])) {
                    foreach ($price['campaigns'] as $campaignId) {

                        $campCategories = Campaign::where('id', $campaignId)->first()->campaign_categories->pluck('name')->toArray();

                        $campName = Campaign::getCountryNameForPrice($campaignId, $price['value'], $price['type']);

                        if (isset($campName)) {
                            $campaignsNames[$campaignId]['name'] = $campName;
                            $campaignsNames[$campaignId]['categories'] = $campCategories;
                        }  
                    }
                }                
            }
        }

        return $campaignsNames;
    }

    public static function getProjectOptions($id)
    {
        $amount = [];

        $pageInstance = PageInstance::find($id);

        if (isset($pageInstance->parameters['amount'])) {
            $amount = $pageInstance->parameters['amount'];  
        }

        $options = [];

        foreach ($amount as $price) {
            if (isset($price['type'])) {
                
                $campaignsNames = [];

                if (isset($price['campaigns'])) {
                    foreach ($price['campaigns'] as $campaignId) {

                        $campCategories = Campaign::where('id', $campaignId)->first()->campaign_categories->pluck('name')->toArray();

                        $campName = Campaign::getCountryNameForPrice($campaignId, $price['value'], $price['type']);

                        if (isset($campName)) {
                            $campaignsNames[$campaignId]['name'] = $campName;
                            $campaignsNames[$campaignId]['categories'] = $campCategories;
                        }  
                    }
                }

                $type = '';
                
                if ((int)$price['type'] === CampaignPrice::TYPE_SINGLE) {
                    $type = 'single';
                } else if ((int)$price['type'] === CampaignPrice::TYPE_MONTHLY) {
                    $type = 'monthly';
                }
                
                if (count($campaignsNames)) {
                    $options[$type][] = [
                        'price' => $price['value'],
                        'campaigns' => $campaignsNames
                    ];
                }
                
            }
        }

        return $options;
    }

    public static function isEmergency($pageInstance)
    {
        $parameters = $pageInstance->parameters;
        $amount = [];
        
        if (isset($parameters['amount'])) {
            $amount = $parameters['amount'];
        }
        
        $campaignIds = [];

        foreach ($amount as $price) {
            if (isset($price['campaigns'])) {
                foreach ($price['campaigns'] as $campaign) {
                    $campaignIds[] = $campaign;
                }
            }
        }

        $campaignIds = array_unique($campaignIds);
        $emergencyCount = Campaign::whereIn('id', $campaignIds)->emergency()->count();
        
        if ($emergencyCount) {
            return true;
        } else {
            return false;
        }
    }
}
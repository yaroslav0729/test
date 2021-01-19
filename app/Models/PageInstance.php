<?php

namespace App\Models;

use App\Models\Template;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Category;
use App\Models\CampaignPrice;
use App\Models\Redirect;

class PageInstance extends Model
{
    use HasFactory;

    const FOOTER_CLASSES = [
        'style-1',
        'style-2',
        'style-3',
        'style-4',
        'style-5'
    ];

    protected $fillable = [
        'page_id',
        'author_id',
        'name',
        'slug',
        'preview_text',
        'preview_img',
        'title',
        'description',
        'keywords',
        'template',
        'parameters',
        'html'
    ];

    public static function boot()
    {
        parent::boot();

        self::updating(function($model){
            $model->is_single = self::isSingleParam($model->parameters);
            $model->is_monthly = self::isMonthlyParam($model->parameters);
            $model->is_appeal = self::isAppealParam($model->parameters);
        });

        self::saved(function ($model) {
            $model->refreshCampaigns();
        });
    }

    public function refreshCampaigns()
    {
        $parameters = $this->parameters;

        $campaigns = [];

        if (isset($parameters['amount'])) {
            foreach ($parameters['amount'] as $price) {
                if (isset($price['campaigns'])) {
                    foreach ($price['campaigns'] as $campaign) {
                        $campaigns[] = $campaign;
                    }
                }
            }
        }

        $campaigns = array_unique($campaigns);
        $this->campaigns()->detach();
        $this->campaigns()->attach($campaigns);
    }

    public function campaigns()
    {
        return $this->belongsToMany('App\Models\Campaign');
    }

    public function refreshParams()
    {
        $this->is_single = self::isSingleParam($this->parameters);
        $this->is_monthly = self::isMonthlyParam($this->parameters);
        $this->is_appeal = self::isAppealParam($this->parameters);

        $this->save();
    }

    protected static function isSingleParam($parameters)
    {
        if (isset($parameters['amount'])) {
            foreach ($parameters['amount'] as $price) {
                if ((isset($price['type'])) && ((int)$price['type'] === CampaignPrice::TYPE_SINGLE)) {
                    return true;
                }
            }
        }

        return false;
    }

    protected static function isMonthlyParam($parameters)
    {
        if (isset($parameters['amount'])) {
            foreach ($parameters['amount'] as $price) {
                if ((isset($price['type'])) && ((int)$price['type'] === CampaignPrice::TYPE_MONTHLY)) {
                    return true;
                }
            }
        }

        return false;
    }

    protected static function isAppealParam($parameters)
    {
        if (isset($parameters['amount'])) {
            foreach ($parameters['amount'] as $price) {
                if (isset($price['campaigns'])) {
                    $campaigns = Campaign::whereIn('id', $price['campaigns'])->emergency()->get();
                    if (count($campaigns)) {
                        return true;
                    }
                    
                }
            }
        }

        return false;
    }

    public function scopeSingle($query)
    {
        return $query->where('is_single', true);
    }

    public function scopeMonthly($query)
    {
        return $query->where('is_monthly', true);
    }

    public function scopeAppeal($query)
    {
        return $query->where('is_appeal', true);
    }

    protected $casts = [
        'parameters' => 'array',
    ];

    public function page()
    {
        return $this->belongsTo('App\Models\Page', 'page_id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'category_page');
    }

    public function author()
    {
        return $this->belongsTo('App\Models\User', 'author_id');
    }

    public function getPublishedAtAttribute()
    {
        return $this->page->published_at;
    }

    public function getCategoryIdsAttribute()
    {
        return $this->categories->pluck('id')->toArray();
    }

    public function getTemplateNameAttribute()
    {
        return Template::getLabel($this->template);
    }

    public function getIsPublishedAttribute()
    {
        return ($this->page->status === \App\Models\Page::PAGE_STATUS_PUBLISHED);
    }

    // public function scopePublished($query)
    // {
    //     return $query->whereHas('page', function(Builder $queryPage) {
    //         $queryPage->where('status', Page::PAGE_STATUS_PUBLISHED);
    //     });
    // }

    public function scopeActual($query)
    {
        return $query->where('actual', true);
    }

    public function renderTemplateParametersForm()
    {
        if ($this->template) {
            return view('templates.form.' . $this->template, [
                'parameters' => $this->parameters,
            ]);
        } else {
            return null;
        }
    }

    public function renderTemplate()
    {
        if ($this->template) {
            return view('templates.presentation.' . $this->template, [
                'parameters' => $this->parameters,
                'pageInstance' => $this
            ]);
        } else {
            return null;
        }
    }

    public function hasFromRedirect()
    {
        $redirects = Redirect::where('url_from', $this->slug)->get();

        return count($redirects) ? true : false; 
    }

    public function getFromRedirects()
    {
        $redirects = Redirect::where('url_from', $this->slug)->get();

        return $redirects; 
    }

    public function hasToRedirect()
    {
        $redirects = Redirect::where('url_to', $this->slug)->get();

        return count($redirects) ? true : false; 
    }

    public function getToRedirects()
    {
        $redirects = Redirect::where('url_to', $this->slug)->get();

        return $redirects; 
    }
}

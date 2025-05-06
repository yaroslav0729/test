<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodPacksQurbaniesPrice extends Model
{
    protected $with = [
        'country',
        'campaign_category',
        'campaigns'
    ];

    protected $fillable = [
        'country_id',
        'project_name',
        'program_name',
        'campaign_category_id',
        'feedback'
    ];

    public function types(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(FoodPacksQurbaniesType::class)->withPivot('price', 'campaign_id');
    }

    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function campaign_category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CampaignCategory::class);
    }

    public function campaigns(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            Campaign::class,
            'food_packs_qurbanies_price_food_packs_qurbanies_type',
            'food_packs_qurbanies_price_id',
            'campaign_id'
        )->distinct();
    }
}

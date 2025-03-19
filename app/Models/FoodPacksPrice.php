<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodPacksPrice extends Model
{
    protected $with = [
        'country',
        'campaign_category'
    ];

    protected $fillable = [
        'country_id',
        'price',
        'campaign_name',
        'project_name',
        'program_name',
        'campaign_category_id'
    ];

    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function campaign_category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CampaignCategory::class);
    }
}

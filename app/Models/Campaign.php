<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'country_id',
        'start_date',
        'end_date'
    ];

    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    public function getCountryNameAttribute()
    {
        return $this->country->name;
    }

    public function campaign_prices()
    {
        return $this->belongsToMany('App\Models\CampaignPrice');
    }

    public function getCampaignPriceIdsAttribute()
    {
        return $this->campaign_prices->pluck('id')->toArray();
    }
}

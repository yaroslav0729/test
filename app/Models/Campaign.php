<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CampaignPrice;

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
        return $this->hasMany('App\Models\CampaignPrice')->orderBy('type')->orderBy('value');
    }

    public function campaign_categories()
    {
        return $this->belongsToMany('App\Models\CampaignCategory', 'campaign_campaign_category', 'campaign_id', 'campaign_category_id');
    }

    public function getCampaignPriceIdsAttribute()
    {
        return $this->campaign_prices->pluck('id')->toArray();
    }

    public function getCampaignCategoriesIdsAttribute()
    {
        return $this->campaign_categories->pluck('id')->toArray();
    }

    public function updatePrices($request)
    {
        if ($request->input('prices')) {

            // update existing prices

            $priceIds = array_keys($request->input('prices'));
            $priceValues = $request->input('prices');
            $priceTypes = $request->input('price_types');

            $prices = CampaignPrice::whereIn('id', $priceIds)->get();

            foreach ($prices as $price) {

                $price->value = $priceValues[$price->id];
                $price->type = $priceTypes[$price->id];

                $price->save();
            }

            // remove deleted on frontend prices

            CampaignPrice::where('campaign_id', $this->id)->whereNotIn('id', $priceIds)->delete();
        }
        // create new prices

        $priceValues = $request->input('prices_new');
        $priceTypes = $request->input('price_types_new');

        if (isset($priceValues)) {
            foreach ($priceValues as $key => $value) {
                CampaignPrice::create([
                    'value' => $value,
                    'type' => $priceTypes[$key],
                    'campaign_id' => $this->id
                ]);
            }
        }
    }
}

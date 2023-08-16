<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CampaignPrice;
use Carbon\Carbon;

class Campaign extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = "Active";
    const STATUS_NOT_STARTED = "Not started";
    const STATUS_FINISHED = "Finished";

    protected $fillable = [
        'name',
        'description',
        'country_id',
        'start_date',
        'end_date',
        'is_emergency',
        'most_needed_area',
        'wp_id',
        'icharm_program_id',
        'icharm_country_id'
    ];

    public static function boot()
    {
        parent::boot();

        self::saved(function ($model) {
            $model->refreshInstances();
        });
    }

    protected function refreshInstances()
    {
        $instances = $this->page_instances;

        foreach ($instances as $instance) {
            $instance->refreshParams();    
        }
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    public function page_instances()
    {
        return $this->belongsToMany('App\Models\PageInstance');
    }

    public function getCountryNameAttribute()
    {
        if (isset($this->country)) {
            return $this->country->name;
        }
        else {
            return $this->name . " - no country selected";
        }
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

    public function getStatusAttribute($query)
    {
        $company = $this;
        $nowDate = Carbon::now()->toDateTimeString();

        if ($nowDate < $this->start_date) return self::STATUS_NOT_STARTED;
        if ($nowDate < $this->end_date) return self::STATUS_ACTIVE;
        if ($nowDate > $this->end_date) return self::STATUS_FINISHED; 
    }

    public function scopeActive($query)
    {
        $nowDate = Carbon::now()->toDateTimeString();

        return $query->where('start_date', '<', $nowDate)
                    ->where('end_date', '>', $nowDate);
    }

    public function scopeEmergency($query)
    {
        return $query->where('is_emergency', true);
                    
    }

    public static function getCountryNameForPrice($campId, $value, $type)
    {
        $campaign = self::where('id', $campId)->active()->
                whereHas('campaign_prices', function ($q) use ($value, $type) {
                    $q->where('value', $value)
                    ->where('type', $type);
                })->first();

        if (isset($campaign)) {
            return $campaign->country_name;
        } else {
            return null;
        }
    }
}

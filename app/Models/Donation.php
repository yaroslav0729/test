<?php

namespace App\Models;

use App\Models\CampaignPrice;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    const STATUS_PROCESSING = 0;
    const STATUS_COMPLETE = 1;
    const STATUS_CANCELED = 2;

    protected $guarded = ['id'];

    public function getTypeNameAttribute()
    {
        if (isset(CampaignPrice::ALL_TYPES[$this->type])) {
            return CampaignPrice::ALL_TYPES[$this->type];
        }

        return "";
    }

    public function getCurrrencySignAttribute()
    {
        return Currency::getSignFromCode($this->currency);
    }

    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
}

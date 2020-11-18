<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignPrice extends Model
{
    use HasFactory;

    const TYPE_SINGLE = 10;
    const TYPE_MONTHLY = 20;

    const ALL_TYPES = [
        self::TYPE_SINGLE => 'single',
        self::TYPE_MONTHLY => 'monthly'
    ];

    public function getTypeLabelAttribute()
    {
        return self::ALL_TYPES[$this->type];
    }

    protected $fillable = [
        'value',
        'type',
        'campaign_id'
    ];

    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign');
    }
}

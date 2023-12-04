<?php

namespace App\Models;

use App\Models\CampaignPrice;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_PROCESSING = 0;
    const STATUS_COMPLETE = 1;
    const STATUS_CANCELED = 2;
    const STATUS_SCHEDULED = 3;

    const TYPE_SINGLE = 10;
    const TYPE_MONTHLY = 20;
    public const TYPE_RAMADAN = 30;

    protected $guarded = ['id'];

    protected $fillable = ['value', 'order_id', 'type', 'currency', 'campaign_id', 'food_pack_id', 'food_pack_qurbani_id', 'food_pack_qurbani_type_id', 'campaign_category_id', 'user_id', 'email', 'note', 'schedule', 'created_at', 'wp_id', 'status', 'commission', 'ip', 'qurbani_name', 'created_at', 'is_recurring', 'upsell', 'goal'];

    protected static function getTypeLabel($type)
    {
        switch ($type) {
            case self::TYPE_SINGLE:
                return 'single';
            case self::TYPE_MONTHLY:
                return 'monthly';
            case self::TYPE_RAMADAN:
                return 'ramadan subscription';
        }
    }

    protected static function getStatusLabel($status)
    {
        switch ($status) {
            case self::STATUS_PROCESSING:
                return "processing";
            case self::STATUS_COMPLETE:
                return "complete";
            case self::STATUS_CANCELED:
                return "canceled";
            case self::STATUS_SCHEDULED:
                return "scheduled";
        }
    }

    protected static function getStatusId($label)
    {
        switch ($label) {
            case "processing":
                return self::STATUS_PROCESSING;
            case "complete":
                return self::STATUS_COMPLETE;
            case "canceled":
                return self::STATUS_CANCELED;
            case "scheduled":
                return self::STATUS_SCHEDULED;
        }
    }

    protected static function getStatusClass($status)
    {
        switch ($status) {
            case self::STATUS_PROCESSING:
                return "";
            case self::STATUS_COMPLETE:
                return "text-info";
            case self::STATUS_CANCELED:
                return "text-danger";
        }
    }

    protected static function getTypes()
    {
        $types = [
            [
                'id' => self::TYPE_SINGLE,
                'name' => self::getTypeLabel(self::TYPE_SINGLE),
            ],
            [
                'id' => self::TYPE_MONTHLY,
                'name' => self::getTypeLabel(self::TYPE_MONTHLY),
            ],
            [
                'id' => self::TYPE_RAMADAN,
                'name' => self::getTypeLabel(self::TYPE_RAMADAN),
            ],
        ];

        return $types;
    }

    public static function getStatuses()
    {
        $statuses = [];
        for ($i = 0; $i < 4; $i++) {
            $statuses[] = [
                'id' => $i,
                'name' => ucfirst(self::getStatusLabel($i)),
                'class' => self::getStatusClass($i),
            ];
        }

        return $statuses;
    }

    public function getTypeNameAttribute()
    {
        if (isset(CampaignPrice::ALL_TYPES[$this->type])) {
            return CampaignPrice::ALL_TYPES[$this->type];
        }

        return "";
    }

    public function getStatusNameAttribute()
    {
        return self::getStatusLabel($this->status);
    }

    public function getCurrrencySignAttribute()
    {
        return Currency::getSignFromCode($this->currency);
    }

    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign');
    }

    public function campaign_category()
    {
        return $this->belongsTo('App\Models\CampaignCategory');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function foodpack()
    {
        return $this->belongsTo(FoodPacksPrice::class, 'food_pack_id', 'id');
    }

    public function foodpackqurbani()
    {
        return $this->belongsTo(FoodPacksQurbaniesPrice::class, 'food_pack_qurbani_id', 'id');
    }

    public function foodpackqurbanitype()
    {
        return $this->belongsTo(FoodPacksQurbaniesType::class, 'food_pack_qurbani_type_id', 'id');
    }

    public function getCampaignName()
    {
        if (isset($this->campaign_id)) {
            return $this->campaign->name;
        } else if (isset($this->food_pack_id)) {
            return $this->foodpack->country->name;
        }
        return 'Quick Donation';
    }

    public function getDonationName()
    {
        $name = 'no campaign';
        if ($this->campaign) {
            $name = $this->campaign->name;
        } elseif (isset($this->foodpackqurbani)) {
            $name = $this->foodpackqurbani->country->name . " Qurbani (" . $this->foodpackqurbanitype->name . ")";
        } elseif (isset($this->foodpack)) {
            $name = "FoodPack " . $this->foodpack->country->name;
        } else if ($this->upsell) {
            $name = 'Provide Rice This Eid';
        }

        return $name;
    }
}

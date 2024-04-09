<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CartItem extends Model
{
    use HasFactory;

    protected $with = ['campaign', 'foodpack'];

    protected $guarded = ['cart_item_id'];

    public static function boot()
    {
        parent::boot();

        $randomStr = Carbon::now()->timestamp;
        $randomStr = $randomStr . '_' . Str::random(20);

        self::created(function ($model) use ($randomStr) {
            $model->cart_item_id = $model->id . '_' . $randomStr;
            $model->save();
        });
    }

    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign');
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

    public function campaign_category()
    {
        return $this->belongsTo('App\Models\CampaignCategory');
    }

    public function createSameItems($quantity)
    {
        $newItems = [];

        for ($i = 0; $i < $quantity; $i++) {
            $newItem = CartItem::create([
                'amount' => $this->amount,
                'campaign_id' => $this->campaign_id,
                'food_pack_id' => $this->food_pack_id,
                'campaign_category_id' => $this->campaign_category_id,
                'period' => $this->period,
                'note' => $this->note,
                'project_id' => $this->projectId,
                'upsell' => $this->upsell,
                'name' => $this->name,
            ]);

            $newItems[] = $newItem->cart_item_id;
        }

        return $newItems;
    }

    public function removeSameItems($quantity = null)
    {
        $sameItems = $this->getSameItems();

        $deletedItems = [];

        foreach ($sameItems as $item) {

            if ($item->id !== $this->id) {

                $deletedItems[] = $item->cart_item_id;
                $item->delete();

                if ((!empty($quantity)) && (count($deletedItems) >= $quantity)) break;
            }
        }

        return $deletedItems;
    }

    public function getSameItems()
    {
        $cartItems = session()->get('cart');
        $items = self::whereIn('cart_item_id', $cartItems)->get();

        $itemsCollected = [];

        foreach ($items as $item) {
            if (($item->amount === $this->amount) &&
                ($item->campaign_id === $this->campaign_id) &&
                ($item->campaign_category_id === $this->campaign_category_id) &&
                ($item->food_pack_id === $this->food_pack_id) &&
                ($item->period === $this->period)
            )

                $itemsCollected[] = $item;
        }

        return $itemsCollected;
    }

    public static function getCart()
    {
        $cartItems = session()->get('cart');

        if (is_array($cartItems)) {

            $items = \App\Models\CartItem::whereIn('cart_item_id', $cartItems)->get();

            $itemsCollected = [];

            foreach ($items as $item) {
                $campaign = !empty($item['campaign_id']) ? $item['campaign_id'] :
                    (!empty($item['food_pack_id']) ? $item['food_pack_id'] :
                        ((!empty($item['food_pack_qurbani_id']) && !empty($item['food_pack_qurbani_type_id'])) ? $item['food_pack_qurbani_id'].$item['food_pack_qurbani_type_id'] : ''));

                $uniqKey = $item['amount'] . '_' . $item['period'] . '_' . $campaign . '_' . $item['campaign_category_id'];
                $itemsCollected[$uniqKey][] = $item;
            }

            return $itemsCollected;
        }

        return [];
    }

    public static function getCartSum()
    {
        $cartItems = session()->get('cart');

        if (is_array($cartItems)) {

            $items = \App\Models\CartItem::whereIn('cart_item_id', $cartItems)->get();

            $sum = 0;
            foreach ($items as $item) {
                $sum = $sum + $item->amount;
            }

            return $sum;
        }

        return 0;
    }

    public static function roundCurrency(float $value)
    {
        if (!$value) {
            return '0.00';
        }

        return number_format(round($value, 2), 2, '.', ',');
    }

    public static function hasMonthlyDonations()
    {
        $cartItems = session()->get('cart');

        if (is_array($cartItems)) {
            $items = \App\Models\CartItem::whereIn('cart_item_id', $cartItems)->get();

            return $items->some(function ($value, $key) {
                return $value->period === 20;
            });
        }

        return false;
    }

    public static function hasSingleDonations()
    {
        $cartItems = session()->get('cart');

        if (is_array($cartItems)) {
            $items = \App\Models\CartItem::whereIn('cart_item_id', $cartItems)->get();

            return $items->some(function ($value, $key) {
                return $value->period === 10;
            });
        }

        return false;
    }
}

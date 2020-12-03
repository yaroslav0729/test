<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CampaignCategory;
use App\Models\CartItem;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $categoryId = null;

        $amount = $request->amount;
        $campaignId = $request->campaigns;
        
        if (isset($request->categories)) {
            $category = CampaignCategory::where('name', $request->categories)->first();
            
            if (isset($category)) {
                $categoryId = $category->id;
            }
        }
        
        $period = $request->period;

        CartItem::create([
            'amount' => $amount,
            'campaign_id' => $campaignId,
            'campaign_category_id' => $categoryId,
            'period' => $period
        ]);

        return redirect()->back();
    }

    public function remove()
    {
        return "remove"; 
    }
}

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

        $cartItem = CartItem::create([
            'amount' => $amount,
            'campaign_id' => $campaignId,
            'campaign_category_id' => $categoryId,
            'period' => $period
        ]);

        $this->sessionCartPut($cartItem->cart_item_id);

        if (request()->ajax()) {
            return response()->json([
                'message' => 'Success message',
                'success' => true,
                'cart_html' => view('parts.modal_cart')->render(),
                'cart_donate' => view('modules.presentation.donation_page_cart')->render(),
                'sum' => CartItem::getCartSum(),
            ]); 
        }

        return redirect()->back();
    }

    public function remove(Request $request, $itemId)
    {
        CartItem::where('cart_item_id', $itemId)->delete();
        $this->sessionCartDelete($itemId);

        if (request()->ajax()) {
            return response()->json([
                'message' => 'Success message',
                'success' => true,
                'cart_html' => view('parts.modal_cart')->render(),
                'cart_donate' => view('modules.presentation.donation_page_cart')->render(),
                'sum' => CartItem::getCartSum(),
            ]); 
        }

        return redirect()->back(); 
    }

    protected function sessionCartPut($itemId)
    {
        $cart = session()->get('cart');
        $cart[] = $itemId;
        session()->put('cart', $cart);
    }

    protected function sessionCartDelete($itemId)
    {
        $cart = session()->get('cart');
        $key = array_search($itemId, $cart);

        if ($key !== false) {
            unset($cart[$key]);
        }

        session()->put('cart', $cart);
    }
}

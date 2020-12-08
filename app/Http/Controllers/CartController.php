<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CampaignCategory;
use App\Models\CartItem;
use App\Models\CampaignPrice;
use App\Models\Donation;
use App\Models\Order;

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
        
        $period = array_search($request->period, CampaignPrice::ALL_TYPES);

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

    public function clear()
    {
        $this->clearCart();
        
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

    protected function clearCart()
    {
        $itemIds = session()->get('cart');

        CartItem::whereIn('cart_item_id', $itemIds)->delete();

        session()->put('cart', []);
    }

    public function paymentForm()
    {
        return view('pages.payment');
    }

    public function order(Request $request)
    {
        $order = Order::create($request->all());

        $cartIds = session()->get('cart');
        $cartItems = CartItem::whereIn('cart_item_id', $cartIds)->get();

        foreach ($cartItems as $cartItem) {
            Donation::create([
                'value' => $cartItem->amount,
                'order_id' => $order->id,
                'type' => $cartItem->period,
                'currency' => 'GBP',
                'campaign_id' => $cartItem->campaign_id,
                'campaign_category_id' => $cartItem->campaign_category_id,
                'user_id' => null, //auth()->user ? auth()->user->id : null,
                'email' => $order->email,
            ]);
        }

        $this->clearCart();

        return redirect('/donate')->with('success', 'Order created successfully');
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

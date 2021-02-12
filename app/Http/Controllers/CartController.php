<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use Illuminate\Http\Request;
use App\Models\CampaignCategory;
use App\Models\CartItem;
use App\Models\CampaignPrice;
use App\Models\Donation;
use App\Models\Order;
use App\Models\Currency;
use App\Services\GlobalPay;
use App\Services\Paypal;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $categoryId = null;

        $amount = $request->amount;
        $campaignId = $request->campaigns;
        $projectId = $request->project_id;

        if (isset($request->categories)) {
            $category = CampaignCategory::where('name', $request->categories)->first();

            if (isset($category)) {
                $categoryId = $category->id;
            }
        }

        if (isset($request->period)) {
            $period = array_search($request->period, CampaignPrice::ALL_TYPES);
        } else {
            $period = CampaignPrice::TYPE_SINGLE;
        }

        $note = $request->note;

        $cartItem = CartItem::create([
            'amount' => $amount,
            'campaign_id' => $campaignId,
            'campaign_category_id' => $categoryId,
            'period' => $period,
            'note' => $note,
            'project_id' => $projectId
        ]);

        $this->sessionCartPut($cartItem->cart_item_id);

        if (request()->ajax()) {
            return response()->json([
                'message' => 'Success message',
                'success' => true,
                'cart_html' => view('parts.modal_cart')->render(),
                'cart_donate' => view('modules.presentation.donation_page_cart')->render(),
                'sum' => CartItem::getCartSum(),
                'sum_for_view' => CartItem::roundCurrency(CartItem::getCartSum()),
            ]);
        }

        return redirect()->back();
    }

    public function remove(Request $request, $itemId)
    {
        $item = CartItem::where('cart_item_id', $itemId)->firstOrFail();
        $deletedItems = $item->removeSameItems();

        foreach ($deletedItems as $delItem) {
            $this->sessionCartDelete($delItem);
        }

        $item->delete();
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

    public function order(OrderRequest $request)
    {
        $order = Order::create($request->all());
        $cartIds = session()->get('cart');

        $cartItems = CartItem::whereIn('cart_item_id', $cartIds)->get();
        $sum = 0;

        foreach ($cartItems as $cartItem) {

            $sum = $sum + $cartItem->amount;

            Donation::create([
                'value' => $cartItem->amount,
                'order_id' => $order->id,
                'type' => $cartItem->period,
                'currency' => 'GBP',
                'campaign_id' => $cartItem->campaign_id,
                'campaign_category_id' => $cartItem->campaign_category_id,
                'user_id' => auth()->user() ? auth()->user()->id : null,
                'email' => $order->email,
                'note' => $cartItem->note,
            ]);
        }

        $this->clearCart();

        $response = null;
        $payLink = null;

        $order->pay_with = $request->pay_method;

        if ($request->pay_method === 'paypal') {
            $response = Paypal::createOrder($sum, 'GBP', 'Order id: ' . $order->id);

            $order->order_id = $response->result->id;
            $payLink = $response->result->links[1]->href;

            $order->save();
        } else {
            $sum = $sum * 100 ;

            $payment = new GlobalPay($sum, 'GBP', [
                'email' => $request->get('email'),
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'post_code' => $request->get('post_code'),
                'phone' => $request->get('phone'),
                'address_1' => $request->get('address_1'),
                'address_2' => $request->get('address_2'),
                'city' => $request->get('city'),
                'notes' => $request->get('notes'),
                'country' => $request->get('country'),
                'county' => $request->get('county'),
            ]);
            $order->order_id = $payment->orderId;

            $responce = $payment->getPayLink();

            if (isset($responce['hppPayByLink'])) {
                $payLink = $responce['hppPayByLink'];
            } else {
                dd($responce);
            }

            $order->save();
        }

        if (empty($payLink)) {
            die('Bad request');
        }

        return redirect($payLink);
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

    protected function refreshItemQuantity($cartItemId, $quantity)
    {
        $needItem = CartItem::findOrFail($cartItemId);
        $sameItems = $needItem->getSameItems();

        if ($quantity > count($sameItems)) {
            $newItemIds = $needItem->createSameItems($quantity - count($sameItems));

            foreach ($newItemIds as $cartId) {
                $this->sessionCartPut($cartId);
            }

        } else if (count($sameItems) > $quantity) {
            $deletedItemIds = $needItem->removeSameItems(count($sameItems) - $quantity);

            foreach ($deletedItemIds as $cartId) {
                $this->sessionCartDelete($cartId);
            }
        }

        $sameItems = $needItem->getSameItems();
    }

    public function refreshQuantity(Request $request)
    {
        $cart = $request->get('cart');

        foreach ($cart as $item) {
            $this->refreshItemQuantity($item['id'], $item['quantity']);
        }

        return response()->json([
            'success' => true,
            'cart_html' => view('parts.modal_cart')->render(),
            'cart_donate' => view('modules.presentation.donation_page_cart')->render(),
            'sum' => CartItem::getCartSum(),
        ]);
    }
}

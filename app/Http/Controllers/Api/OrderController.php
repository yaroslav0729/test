<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendReceipt;
use App\Models\Campaign;
use App\Models\Customer;
use App\Models\Donation;
use App\Models\Order;
use App\Models\StripePayment;
use App\Models\StripeSubscription;
use App\Models\CartItem;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    protected StripeService $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    public function index()
    {
        return response()->json(Order::all());
    }

    public function placeExpressOrder(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email',
                'country' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'post_code' => 'required|string|max:20',
                'phone' => 'nullable|string|max:20',
            ]);

            // Get cart items from session
            $cartIds = session()->get('cart', []);
            if (empty($cartIds)) {
                return response()->json(['error' => 'Cart is empty'], 400);
            }

            $cartItems = CartItem::whereIn('cart_item_id', $cartIds)->get();
            $totalAmount = $cartItems->sum('amount') * 100; // Convert to cents

            DB::beginTransaction();

            $order = Order::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? '',
                'country' => $validated['country'],
                'city' => $validated['city'],
                'address_1' => $validated['address'],
                'post_code' => $validated['post_code'],
                'is_a_gift' => false,
            ]);

            // Create donations for each cart item
            foreach ($cartItems as $cartItem) {
                Donation::create([
                    'value' => $cartItem->amount,
                    'order_id' => $order->id,
                    'type' => $cartItem->period,
                    'currency' => 'GBP',
                    'campaign_id' => $cartItem->campaign_id,
                    'food_pack_id' => $cartItem->food_pack_id,
                    'food_pack_qurbani_id' => $cartItem->food_pack_qurbani_id,
                    'food_pack_qurbani_type_id' => $cartItem->food_pack_qurbani_type_id,
                    'campaign_category_id' => $cartItem->campaign_category_id,
                    'user_id' => auth()->user() ? auth()->user()->id : null,
                    'email' => $order->email,
                    'note' => $cartItem->note,
                    'ip' => $request->ip(),
                    'upsell' => $cartItem->upsell,
                    'goal' => $cartItem->goal,
                    'name' => $cartItem->name,
                ]);
            }

            $stripeCustomer = $this->stripeService->processCustomer($validated);
            $paymentIntent = $this->stripeService->createDirectPayment([
                'amount' => $totalAmount,
                'currency' => 'gbp',
                'customer_id' => $stripeCustomer->id,
                'description' => 'Express checkout payment',
                'receipt_email' => $validated['email'],
                'metadata' => [
                    'order_id' => $order->id,
                    'payment_type' => 'express_checkout',
                ]
            ]);

            $clientSecret = $paymentIntent->client_secret;

            DB::commit();

            return response()->json([
                'order' => $order,
                'client_secret' => $clientSecret,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error placing order: ' . $e->getMessage()], 500);
        }
    }

    // ... existing code ...
}

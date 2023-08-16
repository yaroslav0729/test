<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\StripeService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private StripeService $stripe;

    public function __construct(StripeService $stripeService)
    {
        $this->stripe = $stripeService;
    }

    public function donations()
    {
        return view('user_panel.donations', ['user' => auth()->user()]);
    }

    public function cancelSubscription(string $subscriptionId): \Illuminate\Http\RedirectResponse
    {
        $order = Order::where('subscription_id', $subscriptionId)->first();

        if(is_null($order)) {
            return redirect()->back()->with('stripe-subscription-error', "Subscription doesn't exist");
        }

        $stripeSubscription = $this->stripe->cancelSubscription($subscriptionId);
        if ($stripeSubscription->status === 'canceled') {
            $order->is_subscription_active = false;
            $order->save();
        }

        return redirect()->back()->with('status', 'Subscription successfully canceled');
    }
}

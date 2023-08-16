<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\User;
use App\Services\StripeService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Carbon\Carbon;

use App\Models\Campaign;

use App\Models\CartItem;
use Illuminate\Support\Facades\Hash;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Stripe;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function test()
    {
//
//        dd($stripe->paymentIntents->create([
//            'amount' => 1000,
//            'currency' => 'usd',
//            'confirm' => true,
//            'off_session' => true,
//            'return_url' => 'https://google.com',
//            'payment_method' => 'pm_1Mc6GYFV6h1YME9zpqLx0Ctx',
//            'customer' => 'cus_NMpw1mtuF6XEYr',
//        ]));

//        $mail = 'xyde@mailinator.com';
//
//        $customer = $stripe->customers->search([
//            'query' => 'email:\''.$mail.'\'',
//        ]);
//
//        if (!$customer->isEmpty()) {
//            $customer = $customer->data[0];
//        }

        $stripe = new \Stripe\StripeClient(
            config('stripe.secret_key')
        );

        $invoice = $stripe->invoices->retrieve(
            'in_1MdygSFV6h1YME9zmE7yI3IF'
        );

        $subscription = $stripe->subscriptions->retrieve($invoice->subscription);

        $donate = Donation::create([
            'value' => $subscription->plan->metadata->value,
            'order_id' => $subscription->plan->metadata->order_id,
            'type' => $subscription->plan->metadata->type,
            'currency' => $subscription->plan->metadata->currency,
            'user_id' => $subscription->plan->metadata->user_id,
            'email' => $subscription->plan->metadata->email,
            'note' => $subscription->plan->metadata->note,
            'ip' => $subscription->plan->metadata->ip,
            'status' => 1
        ]);


        dd($invoice);

//        $session = $stripe->checkout->sessions->retrieve('cs_test_a1OpBKXTz4UOPwTav6SPquSHwoMUDljVVMRTAe9d3WjfJIHWZEFTbN8bfI');
//        $subscription = $stripe->subscriptions->retrieve($session->subscription);
//
//        $donate = Donation::create([
//            'value' => $subscription->plan->metadata->value,
//            'order_id' => $subscription->plan->metadata->order_id,
//            'type' => $subscription->plan->metadata->type,
//            'currency' => $subscription->plan->metadata->currency,
//            'user_id' => $subscription->plan->metadata->user_id,
//            'email' => $subscription->plan->metadata->email,
//            'note' => $subscription->plan->metadata->note,
//            'ip' => $subscription->plan->metadata->ip,
//            'status' => 1
//        ]);
//
//        dd($donate);
//        dd($stripe->subscriptions->update(
//            $session->subscription,
//            ['cancel_at' => Carbon::parse($session->created)->addDays(10)->timestamp]
//        ));
////
//        User::where('email', 'jopafil@mailinator.com')->update([
//            'password' => Hash::make('test123')
//        ]);
    }

    public function getStripePortalUrlByCustomerId($customerId)
    {
        $stripe = new \Stripe\StripeClient(
            config('stripe.secret_key')
        );

        $portal = $stripe->billingPortal->sessions->create([
            'customer' => $customerId,
            'return_url' => config('app.url') . '/dashboard',
        ]);

        return $portal->url;
    }
}

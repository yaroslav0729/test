<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\User;
use App\Models\Order;
use App\Services\StripeService;
use App\Traits\SendThankYouEmail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
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
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, SendThankYouEmail;

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

    /**
     * Test email receipts - can be called via Postman or browser
     * GET /test-email-receipt - Shows test form
     * POST /test-email-receipt - Sends test email
     * Body: {
     *   "order_id": 123,
     *   "subject": "Test Email Subject",
     *   "to_email": "test@example.com",
     *   "email_type": "donation" // or "scheduled_qurbani"
     * }
     */
    public function testEmailReceipt(Request $request)
    {
        // If GET request, show a simple test form
        if ($request->isMethod('get')) {
            return response()->json([
                'message' => 'Email Receipt Test Endpoint',
                'usage' => [
                    'method' => 'POST',
                    'url' => url('/test-email-receipt'),
                    'required_fields' => [
                        'order_id' => 'integer (required)',
                        'to_email' => 'email (required)',
                        'email_type' => 'string: donation|scheduled_qurbani (required)'
                    ],
                    'optional_fields' => [
                        'subject' => 'string (optional, defaults to "Test Email Receipt")'
                    ],
                    'example_body' => [
                        'order_id' => 1,
                        'to_email' => 'test@example.com',
                        'email_type' => 'donation',
                        'subject' => 'Test Email Subject'
                    ]
                ],
                'available_orders' => Order::take(5)->get(['id', 'email', 'sum', 'created_at'])
            ]);
        }

        try {
            // Validate required parameters
            $request->validate([
                'order_id' => 'required|integer',
                'to_email' => 'required|email',
                'email_type' => 'required|in:donation,scheduled_qurbani'
            ]);

            $orderId = $request->input('order_id');
            $toEmail = $request->input('to_email');
            $subject = $request->input('subject', 'Test Email Receipt');
            $emailType = $request->input('email_type', 'donation');

            // Find the order
            $order = Order::with(['donations.campaign', 'donations.campaign_category', 'donations.foodpack.country', 'donations.foodpackqurbani.country', 'donations.foodpackqurbanitype'])
                          ->find($orderId);

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found with ID: ' . $orderId,
                    'available_orders' => Order::take(10)->get(['id', 'email', 'sum', 'created_at'])
                ], 404);
            }

            // Override email for testing
            $order->email = $toEmail;

            // Send appropriate email based on type
            if ($emailType === 'scheduled_qurbani') {
                $this->sendThankYouScheduledQurbaniEmail($order);
                $emailTypeSent = 'Scheduled Qurbani Thank You';
            } else {
                $this->sendThankYouEmail($order);
                $emailTypeSent = 'Donation Thank You';
            }

            return response()->json([
                'success' => true,
                'message' => 'Email sent successfully',
                'data' => [
                    'order_id' => $orderId,
                    'to_email' => $toEmail,
                    'subject' => $subject,
                    'email_type' => $emailTypeSent,
                    'order_total' => $order->sum,
                    'donations_count' => $order->donations->count()
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error sending email: ' . $e->getMessage()
            ], 500);
        }
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

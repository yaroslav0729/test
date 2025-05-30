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
use ZipArchive;

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

    public function removeFakeDonations()
    {
        $fakeList = [171047, 171046, 171045, 171044, 171043, 171019, 171018, 170938, 170937, 170936, 170935, 170934, 170881, 170880, 170879, 170878, 170877, 170876, 170875, 170857, 170856, 170663, 170655, 170656, 170657, 170658, 170659, 170660, 170661, 170662, 170664, 170665, 170666, 170667, 170668, 170669, 170670, 170671, 170632, 170597, 170572, 170491, 170350, 170047, 170046, 170048, 170049, 170041, 170042, 170043, 170044, 170045, 169873, 169872, 169871, 169870, 169869, 169868, 169867, 169847, 169798, 169797, 169796, 169795, 169794, 169793, 169792, 169791, 169790, 169789, 169788, 169758, 169757, 169717, 169716, 169715, 169714, 169713, 169712, 169711, 169710, 169658, 169655, 169656, 169657, 169659, 169660, 169643, 169644, 169645, 169646, 169647, 169648, 169650, 169651, 169652, 169653, 169654, 169649, 169639, 169637, 169638, 169641, 169640, 169637, 169636, 169635, 169634, 169633, 169632, 169631, 169630, 169629, 169628, 169627, 169626, 169625, 169624, 169623, 169622, 169621, 169620, 169619, 169618, 169617, 169616, 169615, 169614, 169613, 169612, 169611, 169610, 169609, 169608, 169607, 169606, 169605, 169604, 169603, 169602, 169601, 169600, 169599, 169598, 169597, 169596, 169595, 169594, 169593, 169592, 169591, 169590, 169589, 169588, 169587, 169586, 169585, 169584, 169583, 169298, 169297, 169299, 169300, 169302, 169303, 169301, 168909, 168910, 168870, 168871, 168872, 168873, 168874, 168865, 168866, 168867, 168868, 168869, 168860, 168861, 168862, 168863, 168864, 168855, 168856, 168857, 168858, 168859, 168850, 168851, 168852, 168853, 168854, 168845, 168846, 168847, 168848, 168837, 168838, 168839, 168840, 168841, 168842, 168843, 168844, 168833, 168834, 168835, 168836, 168829, 168830, 168831, 168832, 168798, 168799, 168800, 168801, 168802, 168803, 168804, 168657, 168658, 168659, 168497, 168498, 168371, 168372, 168368, 168369, 168370, 168260, 168261, 167979, 167980, 167909, 167903, 167904, 167905, 167906, 167907, 167908, 167818, 167819, 167820, 167821, 167822, 167823, 167824, 167825, 167826, 167827, 167828, 167829, 167703, 167511, 167512, 167360, 167361, 167303, 167304, 167271, 167199, 167200, 167185, 167186, 167181, 167182, 167183, 167184, 167179, 167180, 167051, 167052, 167053, 167054, 167055, 167056, 167057, 167058, 167059, 167060, 167039, 167040, 167041, 167042, 167043, 167044, 167045, 167046, 167047, 167048, 167049, 167050, 166962, 166963, 166846, 166835, 166810, 166809, 166808, 166801, 166800, 166799, 166798, 166797, 166796, 166795, 166794, 166793, 166792, 166791, 166790, 166789, 166788, 166787, 166786, 166785, 166784, 166783, 166701, 166557, 171561, 171562, 171563, 171564, 171565, 171566, 171567, 171568, 171569, 171570, 171571, 171572, 171573, 171574, 171352, 171353, 171354, 171252, 171241, 171254, 171216, 171217, 171218, 171330, 171197, 171198];
        
        $donationsToDelete = Donation::whereIn('id', $fakeList)->get();
        $donationsCsv = storage_path('app/deleted_donations.csv');
        $donationsFile = fopen($donationsCsv, 'w');
        
        $donationProperties = [
            'id', 'order_id', 'status', 'value', 'goal', 'type', 'upsell', 'is_recurring', 'currency', 'name', 'stripe_payment_intent_id', 'stripe_subscription_id', 'donated_by', 'campaign_id', 'food_pack_id', 'food_pack_qurbani_id', 'food_pack_qurbani_type_id', 'campaign_category_id', 'ihelp_campaign_id', 'user_id', 'email', 'qurbani_name', 'commission', 'note', 'schedule', 'wp_id', 'ip', 'created_at', 'updated_at', 'deleted_at', 'invoice_id', 'account_number', 'sort_code', 'pay_day'
        ];
        
        fputcsv($donationsFile, $donationProperties);
        
        foreach ($donationsToDelete as $donation) {
            $row = [];
            foreach ($donationProperties as $property) {
                $row[] = $donation->$property;
            }
            fputcsv($donationsFile, $row);
        }
        fclose($donationsFile);

        $ordersToDelete = Order::whereIn('id', $donationsToDelete->pluck('order_id'))->get();
        
        $ordersCsv = storage_path('app/deleted_orders.csv');
        $ordersFile = fopen($ordersCsv, 'w');
        
        $orderProperties = ['id','title','first_name','last_name','post_code','address_1','address_2','address_3','city','state','country','county','phone','email','notes','gift_aid','do_calls','do_sms','do_email','do_post','pay_with','pay_day','sort_code','stripe_payment_intent_id','stripe_subscription_id','account_number','order_id','subscription_id','subscription_ids','is_subscription_active','wp_id','created_at','updated_at'];
        
        fputcsv($ordersFile, $orderProperties);
        
        foreach ($ordersToDelete as $order) {
            $row = [];
            foreach ($orderProperties as $property) {
                $row[] = $order->$property;
            }
            // Add the sum attribute
            $row[] = $order->sum;
            fputcsv($ordersFile, $row);
        }
        fclose($ordersFile);

        // Create a zip file using PHP's ZipArchive
        $zipPath = storage_path('app/deleted_data.zip');
        $zip = new ZipArchive();
        
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            $zip->addFile($donationsCsv, 'deleted_donations.csv');
            $zip->addFile($ordersCsv, 'deleted_orders.csv');
            $zip->close();

            // Now proceed with deletion
            foreach ($donationsToDelete as $donation) {
                $donation->forceDelete();
            }

            foreach ($ordersToDelete as $order) {
                $order->delete();
            }

            // Clean up CSV files
            unlink($donationsCsv);
            unlink($ordersCsv);

            // Return the zip file as a download
            return response()->download($zipPath, 'deleted_data.zip')->deleteFileAfterSend(true);
        } else {
            // Clean up in case of error
            if (file_exists($donationsCsv)) unlink($donationsCsv);
            if (file_exists($ordersCsv)) unlink($ordersCsv);
            
            return response()->json([
                'success' => false,
                'message' => 'Error creating zip file'
            ], 500);
        }
    }
}

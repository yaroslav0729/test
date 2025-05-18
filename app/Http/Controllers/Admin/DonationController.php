<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonationEditRequest;
use App\Models\Donation;
use App\Models\Order;
use App\Services\StripeService;
use App\Traits\SendThankYouEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    use SendThankYouEmail;

    private StripeService $stripe;

    public function __construct(StripeService $stripeService)
    {
        $this->stripe = $stripeService;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        [$donations, $daterange, $keyword, $status, $type] = $this->filterDonations($request);
        $sumQuery = clone $donations;
        $giftAidSum = clone $donations;

        $total = $sumQuery->sum('value');

        $totalGiftAid = round($giftAidSum->whereHas('order', function ($query) {$query->where('gift_aid', 1);})->sum('value') * 0.25, 0, 2);

        $donations = $donations->with(['order', 'campaign', 'foodpack', 'foodpackqurbani', 'foodpackqurbanitype', 'user'])->orderBy('created_at', 'desc')->paginate(25)->appends($request->query());
        return view('admin.donations.index', compact('donations', 'keyword', 'daterange', 'status', 'type', 'total', 'totalGiftAid'));
    }

    public function scheduledSacrifice(Request $request)
    {
        [$donations, $daterange, $keyword, $status, $type] = $this->filterDonations($request, true);
        $sumQuery = clone $donations;
        $giftAidSum = clone $donations;

        $total = $sumQuery->sum('value');

        $totalGiftAid = round($giftAidSum->whereHas('order', function ($query) {$query->where('gift_aid', 1);})->sum('value') * 0.25, 0, 2);

        $donations = $donations->with(['order', 'campaign', 'foodpack', 'foodpackqurbani', 'foodpackqurbanitype', 'user'])->orderBy('created_at', 'desc')->paginate(25)->appends($request->query());
        return view('admin.donations.scheduled-qurbani', compact('donations', 'keyword', 'daterange', 'status', 'type', 'total', 'totalGiftAid'));
    }

    public function saveStatus(Donation $donation, Request $request)
    {
        $donation->update([
            'status' => $request->get('status'),
        ]);

        return redirect()->back();
    }

    public function update(DonationEditRequest $request, Donation $donation)
    {
        $donationData = $request->only('note', 'email');
        $orderData = $request->except('note');
        $donation->update($donationData);
        $donation->order->update($orderData);

        return redirect()->back();
    }

    public function resend(Donation $donation)
    {
        $this->sendThankYouEmail($donation->order);

        return redirect()->back()->with('status', 'Message resend successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Donation  $donation
     */
    public function show(Donation $donation)
    {
        return view('admin.donations.show', compact('donation'));
    }

    public function exportCsv(Request $request)
    {
        // Validate request
        if (!$request->user()->can('export-donations')) {
            abort(403, 'Unauthorized action.');
        }

        $fileName = 'donations-' . date('Y-m-d-H-i-s') . '.csv';

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        );

        $columns = ['Id', 'Value', 'Type', 'Is Recurring', 'Status', 'First name', 'Last name', 'Email', 'Phone', 'Date (D/M/Y)', 'Time', 'Campaign', 'Campaign country', 'Project name', 'Program name', 'Name', 'Category', 'Gift aid', 'Paid commission', 'Do SMS', 'Do Email', 'Do Post Marketing', 'Help This Donation 100%', 'Account number', 'Sort code', 'Pay day', 'Payment type', 'Post code', 'Address 1', 'Address 2', 'Address 3', 'City', 'State', 'Country', 'Notes', 'Order notes', 'Order ID', 'Subscription ID'];

        $callback = function () use ($columns, $request) {
            $file = fopen('php://output', 'w');
            if ($file === false) {
                throw new \RuntimeException('Failed to open output stream');
            }
            
            // Add BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, $columns);

            [$donations] = $this->filterDonations($request, $request->has('qurbani'));
            $donations->with('order')->orderBy('created_at', 'desc')->chunk(100, function ($donations) use ($file) {
                foreach ($donations as $donation) {
                    // Sanitize all output data
                    $row = array_map(function($value) {
                        return is_string($value) ? htmlspecialchars($value, ENT_QUOTES, 'UTF-8') : $value;
                    }, [
                        'Id' => $donation->id,
                        'Value' => $donation->value,
                        'Type' => $donation->type_name,
                        'Is Recurring' => $donation->is_recurring ? 'Yes' : 'No',
                        'Status' => $donation->status_name,
                        'First name' => $donation->order ? $donation->order->first_name : '',
                        'Last name' => $donation->order ? $donation->order->last_name : '',
                        'Email' => $donation->email,
                        'Phone' => $donation->order ? $donation->order->phone : '',
                        'Date' => $donation->created_at->format('d/m/Y'),
                        'Time' => $donation->created_at->format('H:i:s'),
                        'Campaign' => $this->getCampaignName($donation),
                        'Campaign country' => $donation->campaign && $donation->campaign->country ? $donation->campaign->country->name : 'No Country',
                        'Project name' => $donation->campaign && $donation->campaign->project_name ? $donation->campaign->project_name : 'No Project',
                        'Program name' => $donation->campaign && $donation->campaign->program_name ? $donation->campaign->program_name : 'No Program',
                        'Name' => $donation->qurbani_name,
                        'Category' => $donation->campaign_category ? $donation->campaign_category->name : 'no category',
                        'Gift aid' => $donation->order && $donation->order->gift_aid ? $donation->order->gift_aid : '',
                        'Paid commission' => $donation->commission ? round($donation->commission, 2) : 'No',
                        'Do SMS' => $donation->order && $donation->order->do_sms ? $donation->order->do_sms : '',
                        'Do Email' => $donation->order && $donation->order->do_email ? $donation->order->do_email : '',
                        'Do Post Marketing' => $donation->order && $donation->order->do_post ? $donation->order->do_post : '',
                        'Help This Donation 100%' => !empty($donation->commission) ? 'Yes' : 'No',
                        'Account number' => $donation->order && $donation->order->account_number ? "'" . $donation->order->account_number . "'" : '',
                        'Sort code' => $donation->order && $donation->order->sort_code ? "'" . $donation->order->sort_code . "'" : '',
                        'Pay day' => $donation->order && $donation->order->pay_day ? $donation->order->pay_day : '',
                        'Payment type' => $donation->order ? $donation->order->pay_with : '',
                        'Post code' => $donation->order ? $donation->order->post_code : '',
                        'Address 1' => $donation->order ? $donation->order->address_1 : '',
                        'Address 2' => $donation->order ? $donation->order->address_2 : '',
                        'Address 3' => $donation->order ? $donation->order->address_3 : '',
                        'City' => $donation->order ? $donation->order->city : '',
                        'State' => $donation->order ? $donation->order->state : '',
                        'Country' => $donation->order ? $donation->order->country : '',
                        'Notes' => $donation->note ? $donation->note : '',
                        'Order notes' => $donation->order ? $donation->order->notes : '',
                        'Order ID' => $donation->order ? $donation->order->order_id : '',
                        'Subscription ID' => $donation->order ? $donation->order->subscription_id : ''
                    ]);

                    fputcsv($file, $row);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportDonationPdf(Request $request, Donation $donation)
    {
        // Validate request
        if (!$request->user()->can('export-donations')) {
            abort(403, 'Unauthorized action.');
        }

        $order = $donation->order;
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $mpdf = new \Mpdf\Mpdf([
            'fontDir' => $fontDirs,
            'fontdata' => $fontData,
            'format' => [210, 297],
            'mode' => 'utf-8',
        ]);

        // Sanitize HTML content
        $html = view('pdf.donation', [
            'order' => $order,
        ])->render();
        
        $html = htmlspecialchars_decode($html);
        $mpdf->WriteHTML($html);

        $headers = [
            'Content-type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="donation-' . $donation->id . '.pdf"',
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'DENY',
            'X-XSS-Protection' => '1; mode=block'
        ];

        return response()->stream(function () use ($mpdf) {
            $file = fopen('php://output', 'w');
            if ($file === false) {
                throw new \RuntimeException('Failed to open output stream');
            }
            fputs($file, $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN));
            fclose($file);
        }, 200, $headers);
    }

    private function getCampaignName($donation)
    {
        if ($donation->campaign) {
            return $donation->campaign->name;
        } elseif (isset($donation->foodpackqurbani)) {
            return $donation->foodpackqurbani->country->name . " Qurbani (" . $donation->foodpackqurbanitype->name . ")";
        } elseif (isset($donation->foodpack)) {
            return "FoodPack " . $donation->foodpack->country->name;
        } else if ($donation->upsell) {
            return $donation->name ?? 'Provide Rice This Eid';
        }
        return 'No Campaign';
    }

    private function filterDonations($request, $isQurbani = false)
    {
        $from = null;
        $to = null;
        $daterange = $request->daterange;
        $keyword = $request->keyword;
        $status = $request->status;
        $type = $request->type;

        if (isset($daterange)) {
            $dates = explode(' - ', $daterange);
            $from = $dates[0];
            $to = $dates[1];
        }

        $donations = new Donation;

        if ($isQurbani) {
            $donations = $donations->whereNotNull('qurbani_name')->where('status', '!=', Donation::STATUS_PROCESSING);
        } else {
            $donations = $donations->whereNull('qurbani_name');
        }

        if (isset($keyword)) {
            $matches = preg_match('/IH\d{1,7}/', $keyword);

            if ($matches) {
                $ihId = (int) filter_var($keyword, FILTER_SANITIZE_NUMBER_INT);
                $donations = $donations->where('order_id', $ihId);
                return [$donations, $daterange, $keyword, $status, $type];
            }

            $searchTemplate = "%$keyword%";

            $donations = $donations->where(function ($query) use ($searchTemplate) {
                $query->where('email', 'like', $searchTemplate)
                    ->orWhereHas('order', function ($query) use ($searchTemplate) {
                        $query->where('email', 'like', $searchTemplate)
                            ->orWhere('last_name', 'like', $searchTemplate)
                            ->orWhere('first_name', 'like', $searchTemplate)
                            ->orWhere('post_code', 'like', $searchTemplate);
                    })
                    ->orWhereHas('campaign', function ($query) use ($searchTemplate) {
                        $query->where('name', 'like', $searchTemplate);
                    });
            });
        }
        $donations = $donations->when(isset($status), function ($query) use ($status) {return $query->where('status', $status);})
            ->when(isset($type), function ($query) use ($type) {return $query->where('type', $type);})
            ->when(isset($from), function ($query) use ($from) {
                return $query->where('created_at', '>=', Carbon::createFromFormat('d/m/Y h:i:s A', $from));
            })
            ->when(isset($to), function ($query) use ($to) {
                return $query->where('created_at', '<=', Carbon::createFromFormat('d/m/Y h:i:s A', $to));
            });

        return [$donations, $daterange, $keyword, $status, $type];
    }

    public function cancelSubscription(string $subscriptionId): \Illuminate\Http\RedirectResponse
    {
        $order = Order::where('subscription_id', $subscriptionId)->first();

        if (is_null($order)) {
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

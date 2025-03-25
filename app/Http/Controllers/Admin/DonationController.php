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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function show(Donation $donation)
    {
        return view('admin.donations.show', compact('donation'));
    }

    public function exportCsv(Request $request)
    {
        $fileName = 'donations.csv';

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
            fputcsv($file, $columns);

            [$donations] = $this->filterDonations($request, $request->has('qurbani'));
            $donations->with('order')->orderBy('created_at', 'desc')->chunk(100, function ($donations) use ($file) {
                foreach ($donations as $donation) {
                    $row['Id'] = $donation->id;
                    $row['Value'] = $donation->value;
                    $row['Type'] = $donation->type_name;
                    $row['Is Recurring'] = $donation->is_recurring ? 'Yes' : 'No';
                    $row['Status'] = $donation->status_name;
                    $row['First name'] = $donation->order ? $donation->order->first_name : '';
                    $row['Last name'] = $donation->order ? $donation->order->last_name : '';
                    $row['Email'] = $donation->email;
                    $row['Phone'] = $donation->order ? $donation->order->phone : '';
                    $row['Date'] = $donation->created_at->format('d/m/Y');
                    $row['Time'] = $donation->created_at->format('H:i:s');
                    if ($donation->campaign) {
                        $row['Campaign'] = $donation->campaign->name;
                    } elseif (isset($donation->foodpackqurbani)) {
                        $row['Campaign'] = $donation->foodpackqurbani->country->name . " Qurbani (" . $donation->foodpackqurbanitype->name . ")";
                    } elseif (isset($donation->foodpack)) {
                        $row['Campaign'] = "FoodPack " . $donation->foodpack->country->name;
                    } else if ($donation->upsell) {
                        $row['Campaign'] = $donation->name ?? 'Provide Rice This Eid';
                    } else {
                        $row['Campaign'] = 'No Campaign';
                    }   
                    $row['Campaign country'] = $donation->campaign && $donation->campaign->country ? $donation->campaign->country->name : 'No Country';
                    $row['Project name'] = $donation->campaign && $donation->campaign->project_name ? $donation->campaign->project_name : 'No Project';
                    $row['Program name'] = $donation->campaign && $donation->campaign->program_name ? $donation->campaign->program_name : 'No Program';
                    $row['Name'] = $donation->qurbani_name;
                    $row['Category'] = $donation->campaign_category ? $donation->campaign_category->name : 'no category';
                    $row['Gift aid'] = $donation->order && $donation->order->gift_aid ? $donation->order->gift_aid : '';
                    $row['Paid commission'] = $donation->commission ? round($donation->commission, 2) : 'No';
                    $row['Do SMS'] = $donation->order && $donation->order->do_sms ? $donation->order->do_sms : '';
                    $row['Do Email'] = $donation->order && $donation->order->do_email ? $donation->order->do_email : '';
                    $row['Do Post Marketing'] = $donation->order && $donation->order->do_post ? $donation->order->do_post : '';
                    $row['Help This Donation 100%'] = !empty($donation->commission) ? 'Yes' : 'No';
                    $row['Account number'] = $donation->order && $donation->order->account_number ? "'" . $donation->order->account_number . "'" : '';
                    $row['Sort code'] = $donation->order && $donation->order->sort_code ? "'" . $donation->order->sort_code . "'" : '';
                    $row['Pay day'] = $donation->order && $donation->order->pay_day ? $donation->order->pay_day : '';
                    $row['Payment type'] = $donation->order ? $donation->order->pay_with : '';
                    $row['Post code'] = $donation->order ? $donation->order->post_code : '';
                    $row['Address 1'] = $donation->order ? $donation->order->address_1 : '';
                    $row['Address 2'] = $donation->order ? $donation->order->address_2 : '';
                    $row['Address 3'] = $donation->order ? $donation->order->address_3 : '';
                    $row['City'] = $donation->order ? $donation->order->city : '';
                    $row['State'] = $donation->order ? $donation->order->state : '';
                    $row['Country'] = $donation->order ? $donation->order->country : '';
                    $row['Notes'] = $donation->note ? $donation->note : '';
                    $row['Order notes'] = $donation->order ? $donation->order->notes : '';
                    $row['Order ID'] = $donation->order ? $donation->order->order_id : '';
                    $row['Subscription ID'] = $donation->order ? $donation->order->subscription_id : '';

                    fputcsv($file, $row);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportDonationPdf(Donation $donation)
    {
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

        $mpdf->WriteHTML(view('pdf.donation', [
            'order' => $order,
        ]));

        $headers = [
            'Content-type' => 'text/pdf',
            'Content-Disposition' => 'attachment; filename="donation.pdf"',
        ];

        return response()->stream(function () use ($mpdf) {
            $file = fopen('php://output', 'w');
            fputs($file, $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN));
            fclose($file);
        }, 200, $headers);
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

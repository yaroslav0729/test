<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $donations = Donation::orderBy('created_at', 'desc')->paginate(25);
        return view('admin.donations.index', compact('donations'));
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

    public function exportCsv()
    {
        $fileName = 'donations.csv';

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        );

        $columns = ['Id', 'Value', 'Type', 'Status', 'First name', 'Last name', 'Email', 'Date (D/M/Y)'];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            Donation::with('order')->orderBy('created_at', 'desc')->chunk(100, function ($donations) use ($file) {
                foreach ($donations as $donation) {

                    $row['Id'] = $donation->id;
                    $row['Value'] = $donation->value;
                    $row['Type'] = $donation->type_name;
                    $row['Status'] = $donation->status_name;
                    $row['First name'] = $donation->order->first_name;
                    $row['Last name'] = $donation->order->last_name;
                    $row['Email'] = $donation->email;
                    $row['Date'] = $donation->created_at->format('d/m/Y');

                    fputcsv($file, $row);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

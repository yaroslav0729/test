<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ResendEmail;
use App\Models\EmailLog;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class EmailLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $from = null;
        $to = null;
        $daterange = $request->daterange;
        $keyword = $request->keyword;

        if (isset($daterange)) {
            $dates = explode(' - ', $daterange);
            $from = $dates[0];
            $to = $dates[1];
        }

        $emailLogs = new EmailLog;

        if (isset($from)) {
            $emailLogs = $emailLogs->whereDate('created_at', '>=', \Carbon\Carbon::createFromFormat('d/m/Y h:i:s A', $from)->format('Y-m-d H:i:s'));
        }
        if (isset($to)) {
            $emailLogs = $emailLogs->whereDate('created_at', '<=', \Carbon\Carbon::createFromFormat('d/m/Y h:i:s A', $to)->format('Y-m-d H:i:s'));
        }
        if (isset($keyword)) {
            $emailLogs = $emailLogs->where('email_to', 'like', '%' . $keyword . '%')
                ->orWhere('email_from', 'like', '%' . $keyword . '%')
                ->orWhere('subject', 'like', '%' . $keyword . '%');
        }

        $emailLogs = $emailLogs->paginate(20)->appends($request->query());
        return view('admin.email_logs.index', compact('emailLogs', 'keyword', 'daterange'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(EmailLog $emailLog)
    {
        return view('admin.email_logs.show', compact('emailLog'));
    }

    public function showEmail(EmailLog $emailLog)
    {
        return view('admin.email_logs.show_email', compact('emailLog'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailLog $emailLog)
    {
        $emailLog->delete();

        return redirect()->route('admin.email_logs.index')->with('status', 'Email log deleted successfully!');
    }

    public function resend(EmailLog $emailLog)
    {
        $emailTo = $emailLog->email_to;
        $subject = $emailLog->subject;
        $emailFrom = $emailLog->email_from;
        $body = $emailLog->body;

        Mail::to($emailTo)->send(new ResendEmail($emailFrom, $subject, $body));

        return redirect()->route('admin.email_logs.index')->with('status', 'Email resent successfully!');
    }
}

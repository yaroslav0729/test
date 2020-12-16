<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ResendEmail;
use App\Models\EmailLog;
use Illuminate\Support\Facades\Mail;

class EmailLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emailLogs = EmailLog::paginate(20);
        return view('admin.email_logs.index', ['emailLogs' => $emailLogs]);
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

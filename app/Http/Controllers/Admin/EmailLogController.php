<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailLog;

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
}

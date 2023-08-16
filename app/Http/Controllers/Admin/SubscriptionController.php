<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Http\Requests\SubscribeRequest;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::paginate(10);

        return view('admin.subscription.index', compact('subscriptions'));
    }

    public function destroy($id)
    {
        $subscriptions = Subscription::findOrFail($id);
        $subscriptions->delete();

        return redirect()->route('admin.subscription.index')->with('status', 'Subscriptions deleted successfully!');
    }

    public function subscribe(SubscribeRequest $request)
    {
        $subscription = Subscription::create([
            'email' => $request->input('email')
        ]);

        return response()->json([
            'message' => 'You are subscribed successfully',
            'success' => true,
        ]); 
    }
}

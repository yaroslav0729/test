<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\SuccessfulPasswordResetLinkRequestResponse;

class ForgotPasswordResponse implements SuccessfulPasswordResetLinkRequestResponse
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        if ($request->ajax()) {
            return response()->json([
                'messageSuccess' => 'We have emailed your password reset link!'
            ]);
        }

        return redirect()->back()->with('status', 'We have emailed your password reset link!');
    }
}
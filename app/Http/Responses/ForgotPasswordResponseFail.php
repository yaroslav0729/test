<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\FailedPasswordResetLinkRequestResponse;

class ForgotPasswordResponseFail implements FailedPasswordResetLinkRequestResponse
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
                'errors' => [
                    'email' => [
                        'Wrong email'
                    ]
                ]
            ], 422);
        }

        return redirect()->back()->withErrors(['email' => ['Wrong email']]);
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Forgot Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Handle forgot password request
     *
     * @param ForgotPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgot(ForgotPasswordRequest $request)
    {
        return $this->sendResetLinkEmail($request);
    }

    /**
     * Send reset link response.
     *
     * @param Request $request
     * @param $response
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return response()->json(['message' => [trans($response)]]);
    }

    /**
     * Send reset link failed response.
     *
     * @param Request $request
     * @param $response
     * @throws AuthorizationException
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        throw new AuthorizationException(trans($response));
    }
}

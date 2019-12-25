<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactUsRequest;
use App\Mail\ContactUsMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    /**
     * Send email with from the contact form
     *
     * @param ContactUsRequest $request
     * @return JsonResponse
     */
    public function contactUs(ContactUsRequest $request)
    {
        Mail::to(env('MAIL_FROM_ADDRESS'))->send(new ContactUsMail($request->only(['data'])['data']));

        return response()->json([], JsonResponse::HTTP_NO_CONTENT);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', Contact::class);

        return response()->json(ContactResource::collection(Contact::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ContactRequest $request
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ContactRequest $request)
    {
        $this->authorize('store', Contact::class);

        $contact = Contact::create(
            $request->only(['first_name', 'last_name', 'email', 'phone'])
        );

        return response()->json(ContactResource::make($contact), JsonResponse::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ContactRequest $request
     * @param $contact_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(ContactRequest $request, $contact_id)
    {
        $contact = Contact::findOrFail($contact_id);
        $this->authorize('update', $contact);

        $contact->update(
            $request->only(['first_name', 'last_name', 'email', 'phone'])
        );

        return response()->json(ContactResource::make($contact), JsonResponse::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $contact_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($contact_id)
    {
        $contact = Contact::findOrFail($contact_id);
        $this->authorize('store', $contact);

        $contact->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\JsonResponse;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', Address::class);

        return response()->json(AddressResource::collection(Address::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddressRequest $request
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(AddressRequest $request)
    {
        $this->authorize('store', Address::class);

        $address = Address::create($request->all());

        return response()->json(new AddressResource($address), JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param $address_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($address_id)
    {
        $address = Address::findOrFail($address_id);
        $this->authorize('show', $address);

        return response()->json(AddressResource::make($address));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AddressRequest $request
     * @param $address_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(AddressRequest $request, $address_id)
    {
        $address = Address::findOrFail($address_id);
        $this->authorize('update', $address);

        $address->update($request->all());

        return response()->json(AddressResource::make($address), JsonResponse::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $address_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($address_id)
    {
        $address = Address::findOrFail($address_id);
        $this->authorize('destroy', $address);

        $address->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}

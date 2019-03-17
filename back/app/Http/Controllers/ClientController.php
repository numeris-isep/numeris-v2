<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Address;
use App\Models\Client;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', Client::class);

        return response()->json(ClientResource::collection(Client::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ClientRequest $request
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ClientRequest $request)
    {
        $this->authorize('store', Client::class);

        $client_request = $request->except([
            'street', 'zip_code', 'city'
        ]);
        $address_request = $request->only([
            'street', 'zip_code', 'city',
        ]);

        $client = Client::create($client_request);
        $address = Address::create($address_request);
        $address->client()->save($client);

        return response()->json(new ClientResource($client), JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param $client_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($client_id)
    {
        $client = Client::findOrFail($client_id);
        $this->authorize('show', $client);

        $client->load(['address', 'conventions', 'conventions.rates', 'projects']);

        return response()->json(ClientResource::make($client));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ClientRequest $request
     * @param $client_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(ClientRequest $request, $client_id)
    {
        $client = Client::findOrFail($client_id);
        $this->authorize('update', $client);

        $client_request = $request->except([
            'street', 'zip_code', 'city'
        ]);
        $address_request = $request->only([
            'street', 'zip_code', 'city',
        ]);

        $client->update($client_request);
        $client->address()->update($address_request);

        return response()->json(ClientResource::make($client), JsonResponse::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $client_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($client_id)
    {
        $client = Client::findOrFail($client_id);
        $this->authorize('destroy', $client);

        // DISCLAIMER: The following line removes the client as well as its
        // related projects and missions
        $client->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}

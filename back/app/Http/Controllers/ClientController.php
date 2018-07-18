<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Http\Resources\ClientResource;
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

        $client = Client::create($request->all());

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

        $client->load(['address', 'conventions']);

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

        $client->update($request->all());

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

        $client->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}

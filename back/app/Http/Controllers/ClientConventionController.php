<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConventionRequest;
use App\Http\Resources\ConventionResource;
use App\Models\Client;
use App\Models\Convention;
use Illuminate\Http\JsonResponse;

class ClientConventionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index($client_id)
    {
        $project = Client::findOrFail($client_id);
        $this->authorize('index', Convention::class);

        return response()->json(ConventionResource::collection($project->conventions));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ConventionRequest $request
     * @param $client_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ConventionRequest $request, $client_id)
    {
        $client = Client::findOrFail($client_id);
        $this->authorize('store', Convention::class);

        $convention = Convention::create($request->all());
        $client->conventions()->save($convention);

        return response()->json(ConventionResource::make($convention), JsonResponse::HTTP_CREATED);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\PreferenceRequest;
use App\Http\Resources\PreferenceResource;
use App\Models\Preference;
use Illuminate\Http\JsonResponse;

class PreferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', Preference::class);

        return response()->json(PreferenceResource::collection(Preference::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PreferenceRequest $request
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(PreferenceRequest $request)
    {
        $this->authorize('store', Preference::class);

        $preference = Preference::create($request->all());

        return response()->json(new PreferenceResource($preference), JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param $preference_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($preference_id)
    {
        $preference = Preference::findOrFail($preference_id);
        $this->authorize('show', $preference);

        return response()->json(PreferenceResource::make($preference));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PreferenceRequest $request
     * @param $preference_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(PreferenceRequest $request, $preference_id)
    {
        $preference = Preference::findOrFail($preference_id);
        $this->authorize('update', $preference);

        $preference->update($request->all());

        return response()->json(PreferenceResource::make($preference), JsonResponse::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $preference_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($preference_id)
    {
        $preference = Preference::findOrFail($preference_id);
        $this->authorize('destroy', $preference);

        $preference->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}

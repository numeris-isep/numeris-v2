<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConventionRequest;
use App\Http\Resources\ConventionResource;
use App\Models\Convention;
use App\Models\Rate;
use Illuminate\Http\JsonResponse;

class ConventionController extends Controller
{
    public function store(ConventionRequest $request)
    {
        $this->authorize('store', Convention::class);

        $convention_request = $request->only(['client_id', 'name']);
        $rates_request = $request->only(['rates'])['rates'];

        $convention = Convention::create($convention_request);

        foreach ($rates_request as $rate) {
            $rate = Rate::create($rate);
            $convention->rates()->save($rate);
        }

        return response()->json('test');
//        return response()->json(ConventionResource::make($convention->load('rates')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ConventionRequest $request
     * @param $convention_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(ConventionRequest $request, $convention_id)
    {
        $convention = Convention::findOrFail($convention_id);
        $this->authorize('update', $convention);

        $convention->update($request->all());

        return response()->json(ConventionResource::make($convention), JsonResponse::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $convention_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($convention_id)
    {
        $convention = Convention::findOrFail($convention_id);
        $this->authorize('destroy', $convention);

        $convention->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}

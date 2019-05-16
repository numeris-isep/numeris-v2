<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConventionRequest;
use App\Http\Resources\ConventionResource;
use App\Models\Convention;
use App\Models\Rate;
use Illuminate\Http\JsonResponse;

class ConventionController extends Controller
{
    /**
     * Display the specified resource.
     *
     */
    public function show($convention_id)
    {
        $convention = Convention::findOrFail($convention_id);
        $this->authorize('show', $convention);

        return response()->json(ConventionResource::make($convention->load('rates')));
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

        $convention_request = $request->only('name');
        $rates_request = $request->only('rates')['rates'];

        $convention->update($convention_request);

        $old_rates = $convention->rates->keyBy('id');

        foreach ($rates_request as $rate_request) {
            if ($rate_request['id']) {
                // If rate exists, update it
                $rate = Rate::find($rate_request['id']);

                if ($rate) {
                    $rate->update($rate_request);
                    $old_rates->forget($rate->id);
                }
            } else {
                // If rate does not exists, create it
                $rate = Rate::create($rate_request);
                $convention->rates()->save($rate);
            }
        }

        // TODO: delete only if there is no billing value
        // Delete the remaining rates
        foreach ($old_rates as $old_rate) {
            $old_rate->delete();
        }

        return response()->json(ConventionResource::make($convention->load('rates')), JsonResponse::HTTP_CREATED);
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

        // This action will delete all the associated rates as well
        $convention->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}

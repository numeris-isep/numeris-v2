<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConventionRequest;
use App\Http\Resources\ConventionResource;
use App\Models\Convention;
use Illuminate\Http\JsonResponse;

class ConventionController extends Controller
{
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

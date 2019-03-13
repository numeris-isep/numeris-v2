<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationRequest;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use Illuminate\Http\JsonResponse;

class ApplicationController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param ApplicationRequest $request
     * @param $application_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(ApplicationRequest $request, $application_id)
    {
        $application = Application::findOrFail($application_id);
        $this->authorize('update', $application);

        $application->update($request->all());

        return response()->json(ApplicationResource::make($application), JsonResponse::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $application_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($application_id)
    {
        $application = Application::findOrFail($application_id);
        $this->authorize('destroy', $application);

        $application->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
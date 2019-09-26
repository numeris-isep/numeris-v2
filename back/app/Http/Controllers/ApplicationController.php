<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationRequest;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Notifications\ApplicationNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the status with their translation.
     *
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function indexStatus()
    {
        $this->authorize('index-status', Application::class);

        return response()->json(Application::statusTranslations());
    }

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

        $application->user->sendApplicationNotification($application);

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

<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationRequest;
use App\Http\Resources\ApplicationResource;
use App\Mail\ApplicationRemovedMail;
use App\Models\Application;
use App\Notifications\ApplicationNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(ApplicationRequest $request)
    {
        $this->authorize('index', Application::class);

        return response()->json(ApplicationResource::collection(Application::findByYear($request['year'])));
    }

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

        $this->sendApplicationRemovedMail($application);

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * @param Application $application
     */
    private function sendApplicationRemovedMail(Application $application)
    {
        try {
            Mail::to($application->mission->user)
                ->cc(env('MAIL_FROM_ADDRESS'))
                ->send(new ApplicationRemovedMail($application));
        } catch (\Exception $exception) {}
    }
}

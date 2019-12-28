<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationRequest;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\Mission;
use App\Models\User;
use App\Notifications\ApplicationNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;

class MissionApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     * List the applications of a user
     *
     * @return \Illuminate\Http\Response
     */
    public function index($mission_id)
    {
        $mission = Mission::findOrFail($mission_id);
        $this->authorize('index-mission-application', $mission);

        $this->validate(request(), [
            'status' => 'string|in:' . implode(',', Application::statuses()),
        ]);

        return response()->json(ApplicationResource::collection(
            $mission->applicationsWhoseStatusIs(request()->status)
                ->load(['user', 'user.roles', 'bills', 'user.payslips'])
        ));
    }

    /**
     * Store a newly created resource in storage.
     * Case where a staff or administrator is adding a user to a given mission
     *
     * @param ApplicationRequest $request
     * @param $mission_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ApplicationRequest $request, $mission_id)
    {
        $mission = Mission::findOrFail($mission_id);
        $user = User::findOrFail($request->get('user_id'));
        $this->authorize('store-mission-application', [$user, $mission]);

        $application = Application::create([
            'type'      => Application::STAFF_PLACEMENT,
            'status'    => Application::ACCEPTED,
        ]);
        $mission->applications()->save($application);
        $user->applications()->save($application);

        $application->load(['user', 'user.roles','mission']);

        $user->sendApplicationNotification($application);

        return response()->json(new ApplicationResource($application), JsonResponse::HTTP_CREATED);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationRequest;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\Mission;
use App\Models\User;
use Illuminate\Http\JsonResponse;

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
                ->load(['user', 'bills'])
        ));
    }

    /**
     * Store a newly created resource in storage.
     * Case where a staff or administrator is adding a user to a given mission
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApplicationRequest $request, $mission_id)
    {
        $mission = Mission::findOrFail($mission_id);
        $user = User::findOrFail($request->get('user_id'));
        $this->authorize('store-mission-application', $mission);

        $application = Application::create([
            'type'      => Application::STAFF_PLACEMENT,
            'status'    => Application::ACCEPTED,
        ]);
        $mission->applications()->save($application);
        $user->applications()->save($application);

        $application->load(['user', 'mission']);

        return response()->json(new ApplicationResource($application), JsonResponse::HTTP_CREATED);
    }
}

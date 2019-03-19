<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationRequest;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\Mission;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     * List the applications of a user
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $user = User::findOrFail($user_id);
        $this->authorize('index-application', $user);

        return response()->json(ApplicationResource::collection(
            $user->applications
                ->load([
                    'mission' => function($m) {
                    return $m->orderBy('start_at');
                }])
                ->load('mission.address', 'mission.project.client')
        ));
    }

    /**
     * Store a newly created resource in storage.
     * Case where a user is applying to a given mission
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApplicationRequest $request, $user_id)
    {
        $user = User::findOrFail($user_id);
        $mission = Mission::findOrFail($request->get('mission_id'));
        $this->authorize('store-application', User::class);

        $application = Application::create([
            'type'      => Application::USER_APPLICATION,
            'status'    => Application::WAITING,
        ]);
        $user->applications()->save($application);
        $mission->applications()->save($application);

        return response()->json(new ApplicationResource($application), JsonResponse::HTTP_CREATED);
    }
}

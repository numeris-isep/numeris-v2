<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Mission;
use App\Models\User;
use Illuminate\Http\Request;

class MissionUserController extends Controller
{
    /**
     * Users that have not applied to the mission.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function indexNotApplied($mission_id)
    {
        $mission = Mission::findOrFail($mission_id);
        $this->authorize('index-not-applied', $mission);

        $this->validate(request(), [
            'page'      => 'integer|min:1',
            'search'    => 'string',
            'role'      => 'string',
            'promotion' => 'string',
        ]);

        $missionUsers = $mission->users();
        $allUsers = User::filtered(
            request()->search,
            request()->role,
            request()->promotion
        )
            ->filter(function($user) use ($mission) {
                if ($mission->project->is_private) {
                    return $user->belongsToProject($mission->project) && $user->activated;
                } else {
                    return $user->activated;
                }
            })
            ->load(['roles']);

        $users = $allUsers->diff($missionUsers)
            ->paginate(10, request()->page)
            ->withPath(route('users.index'));

        return UserResource::collection($users);
    }
}

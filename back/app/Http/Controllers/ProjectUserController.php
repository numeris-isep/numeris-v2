<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Project;
use App\Models\User;
use App\ProjectUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $project_id
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index($project_id)
    {
        $project = Project::private()->findOrFail($project_id);
        $this->authorize('index', User::class);

        $this->validate(request(), [
            'page'      => 'integer|min:1',
            'search'    => 'string',
            'role'      => 'string',
            'promotion' => 'string',
        ]);

        $users = User::filtered(
            request()->search,
            request()->role,
            request()->promotion,
            $project->id
        )->load(['roles'])
            ->sortByDesc('created_at')
            ->paginate(10, request()->page)
            ->withPath(route('users.index'));

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectUserRequest $request, $project_id)
    {
        $project = Project::private()->findOrFail($project_id);
        $user = User::findOrFail($request->get('user_id'));
        $this->authorize('store', [ProjectUser::class, $project, $user]);

        $project->addUser($user);

        return response()->json(UserResource::make($user), JsonResponse::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($project_id, $user_id)
    {
        $project = Project::private()->findOrFail($project_id);
        $user = User::findOrFail($user_id);
        $this->authorize('destroy', [ProjectUser::class, $project, $user]);

        $project->removeUser($user);

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}

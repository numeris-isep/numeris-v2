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
        $this->authorize('index', ProjectUser::class);

        $this->validate(request(), [
            'page'      => 'integer|min:1',
            'search'    => 'string',
            'role'      => 'string',
            'promotion' => 'string',
            'inProject' => 'string',
        ]);

        $users = User::filtered(
            request()->search,
            request()->role,
            request()->promotion,
            $project->id,
            request()->inProject ? true : false
        )->load(['roles'])
            ->sortByDesc('created_at');

        if (request()->page) {
            return UserResource::collection(
                $users->paginate(10, request()->page)
                    ->withPath(route('users.index'))
            );
        } else {
            return response()->json(UserResource::collection($users));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProjectUserRequest $request
     * @param $project_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
     * @param $project_id
     * @param $user_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
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

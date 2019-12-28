<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRoleRequest;
use App\Http\Resources\UserRoleResource;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $user_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index($user_id)
    {
        $user = User::findOrFail($user_id);
        $this->authorize('index', UserRole::class);

        $roles = $user->roles;

        return response()->json(UserRoleResource::collection($roles));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRoleRequest $request
     * @param $user_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(UserRoleRequest $request, $user_id)
    {
        $user = User::findOrFail($user_id);
        $role = Role::findOrFail($request->get('role_id'));
        $this->authorize('store', [UserRole::class, $user, $role]);

        $user->setRole($role);

        return response()->json(UserRoleResource::make($user->role()), JsonResponse::HTTP_CREATED);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', User::class);

        return response()->json(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $this->authorize('store', User::class);

        $user = User::create($request->all());

        return response()->json($user, JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('show', $user);

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        $user->update($request->all());

        return response()->json($user, JsonResponse::HTTP_CREATED);
    }

    /**
     * Update profile
     *
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function updateProfile(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update-profile', $user);

        // Filtering the request to only update the fields an user is allowed to update
        $user->update($request->only([
            'phone',
            'nationality',
            'birth_date',
            'birth_city',
            'social_insurance_number',
            'iban',
            'bic'
        ]));

        return response()->json($user, JsonResponse::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('destroy', $user);

        $user->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}

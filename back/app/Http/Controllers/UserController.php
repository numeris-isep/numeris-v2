<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Address;
use App\Models\Preference;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', User::class);

        return response()->json(UserResource::collection(User::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(UserRequest $request)
    {
        $this->authorize('store', User::class);

        // Encrypt password
        $request['password'] = bcrypt($request['password']);

        $user_request = $request->only([
            'username', 'email', 'password',
            'first_name', 'last_name', 'student_number',
            'promotion', 'phone', 'nationality',
            'birth_date', 'birth_city',
            'social_insurance_number', 'iban', 'bic',
        ]);
        $address_request = $request->only([
            'street', 'zip_code', 'city',
        ]);

        $user = User::create($user_request);
        $address = Address::create($address_request);
        $address->user()->save($user);

        return response()->json(UserResource::make($user), JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param $user_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($user_id)
    {
        $user = User::findOrFail($user_id);
        $this->authorize('show', $user);

        $user->load(['address', 'preference']);

        if (auth()->user()->role()->isSuperiorOrEquivalentTo('staff')) {
            $user->load([
                'roles' => function($r) {
                    return $r->orderBy('created_at', 'desc');
                }
            ]);
        }

        return response()->json(UserResource::make($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param $user_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UserRequest $request, $user_id)
    {
        $user = User::findOrFail($user_id);
        $this->authorize('update', $user);

        // Encrypt password
        $request['password'] = bcrypt($request['password']);

        $user_request = $request->only([
            'username', 'email', 'password',
            'first_name', 'last_name', 'student_number',
            'promotion', 'phone', 'nationality',
            'birth_date', 'birth_city',
            'social_insurance_number', 'iban', 'bic',
        ]);
        $address_request = $request->only([
            'street', 'zip_code', 'city',
        ]);

        $user->update($user_request);
        $user->address()->update($address_request);

        return response()->json(UserResource::make($user), JsonResponse::HTTP_CREATED);
    }

    /**
     * Update profile.
     *
     * @param UserRequest $request
     * * @param $user_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function updateProfile(UserRequest $request, $user_id)
    {
        $user = User::with('address')->findOrFail($user_id);
        $this->authorize('update-profile', $user);

        // Filtering the request to only update the fields an user is allowed to update
        $user_request = $request->only([
            'phone', 'nationality', 'birth_date', 'birth_city',
            'social_insurance_number', 'iban', 'bic'
        ]);
        $address_request = $request->only([
            'street', 'zip_code', 'city',
        ]);

        $user->update($user_request);

        if ($user->address) {
            $user->address()->update($address_request);
        } else {
            $address = Address::create($address_request);
            $address->user()->save($user);
        }

        return response()->json(UserResource::make($user), JsonResponse::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $user_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($user_id)
    {
        $user = User::findOrFail($user_id);
        $this->authorize('destroy', $user);

        $user->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}

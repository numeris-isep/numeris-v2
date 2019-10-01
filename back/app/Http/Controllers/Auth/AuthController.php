<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\UserRequest;
use App\Models\Address;
use App\Models\Preference;
use App\Models\Role;
use App\Http\Requests\AuthRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        $user = User::where('email', request(['email']))->first();

        if (! $user) {
            return response()->json(
                ['errors' => ['login' => [trans('validation.login')]]],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $token = auth()->claims(['rol' => $user->role()->name])
            ->setTTL(120) // <-- token valid for 2 hours
            ->attempt($credentials);

        if (! $token) {
            return response()->json(['errors' => ['login-form' => [trans('validation.login')]]], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Subscribe a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function subscribe(UserRequest $request)
    {
        $request['password'] = bcrypt($request['password']);

        $user_request = $request->only([
            'email', 'password', 'first_name',
            'last_name', 'promotion', 'birth_date',
        ]);
        $address_request = $request->only(['address'])['address'];

        $user = User::create($user_request);
        $address = Address::create($address_request);
        $address->user()->save($user);
        Preference::init()->user()->save($user);
        $user->roles()->attach(Role::findByName(Role::STUDENT));

        return response()->json(UserResource::make($user), JsonResponse::HTTP_CREATED);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function currentUser()
    {
        $user = auth()->user()->load(['address', 'preference', 'payslips']);

        if ($user->role()->isSuperiorOrEquivalentTo(Role::STAFF)) {
            $user->load([
                'roles' => function($r) {
                    return $r->orderBy('created_at', 'desc');
                }
            ]);
        }
        return response()->json(UserResource::make($user));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => [trans('api.logout')]]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token
        ]);
    }
}

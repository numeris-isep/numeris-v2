<?php

namespace Tests\Feature\Auth\Login;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class LoginDeveloperTest extends TestCase
{
    /**
     * @group developer
     */
    public function testDeveloperLoggingIn()
    {
        $user = User::where('email', Role::DEVELOPER . '@isep.fr')->first();

        $data = [
            'email'     => $user->email,
            'password'  => 'azerty'
        ];

        $this->json('POST', route('login'), $data)
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure(['access_token']);
    }

    /**
     * @group developer
     */
    public function testDeveloperLoggingInWithWrongPassword()
    {
        $user = User::where('email', Role::DEVELOPER . '@isep.fr')->first();

        $data = [
            'email'     => $user->email,
            'password'  => 'wrong-password'
        ];

        $this->json('POST', route('login'), $data)
            ->assertStatus(JsonResponse::HTTP_UNAUTHORIZED)
            ->assertJson(['errors' => ['login-form' => [trans('validation.login')]]]);
    }
}

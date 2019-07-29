<?php

namespace Tests\Feature\Auth\Login;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;
use App\Models\Role;

class LoginStudentTest extends TestCase
{
    /**
     * @group student
     */
    public function testStudentLoggingIn()
    {
        $user = User::where('email', Role::STUDENT . '@isep.fr')->first();

        $data = [
            'email'     => $user->email,
            'password'  => 'azerty'
        ];

        $this->json('POST', route('login'), $data)
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure(['access_token']);
    }

    /**
     * @group student
     */
    public function testStudentLoggingInWithWrongPassword()
    {
        $user = User::where('email', Role::STUDENT . '@isep.fr')->first();

        $data = [
            'email' => $user->email,
            'password' => 'wrong-password'
        ];

        $this->json('POST', route('login'), $data)
            ->assertStatus(JsonResponse::HTTP_UNAUTHORIZED)
            ->assertJson(['errors' => ['login-form' => [trans('validation.login')]]]);
    }
}

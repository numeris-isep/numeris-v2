<?php

namespace Tests\Feature\Auth\Login;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class LoginStaffTest extends TestCase
{
    /**
     * @group staff
     */
    public function testStaffLoggingIn()
    {
        $user = User::where('email', Role::STAFF . '@isep.fr')->first();

        $data = [
            'email'     => $user->email,
            'password'  => 'azertyuiop'
        ];
        $this->markTestSkipped('must be revisited.');

        $this->json('POST', route('login'), $data)
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure(['access_token']);
    }

    /**
     * @group staff
     */
    public function testStaffLoggingInWithWrongPassword()
    {
        $user = User::where('email', Role::STAFF . '@isep.fr')->first();

        $data = [
            'email'     => $user->email,
            'password'  => 'wrong-password'
        ];
        $this->markTestSkipped('must be revisited.');

        $this->json('POST', route('login'), $data)
            ->assertStatus(JsonResponse::HTTP_UNAUTHORIZED)
            ->assertJson(['errors' => ['login-form' => [trans('validation.login')]]]);
    }
}

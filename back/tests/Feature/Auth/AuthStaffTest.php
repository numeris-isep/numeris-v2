<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthStaffTest extends TestCase
{
    /**
     * @group staff
     */
    public function testStaffLoggingIn()
    {
        $user = User::where('username', 'staff')->first();

        $data = [
            'email'     => $user->email,
            'password'  => 'azerty'
        ];

        $this->json('POST', route('login'), $data)
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure(['access_token']);
    }

    /**
     * @group staff
     */
    public function testStaffLoggingInWithWrongPassword()
    {
        $user = User::where('username', 'staff')->first();

        $data = [
            'email'     => $user->email,
            'password'  => 'wrong-password'
        ];

        $this->json('POST', route('login'), $data)
            ->assertStatus(JsonResponse::HTTP_UNAUTHORIZED)
            ->assertJson([
                'error' => trans('api.403')
            ]);
    }
}

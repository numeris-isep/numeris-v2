<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthStudentTest extends TestCase
{
    /**
     * @group student
     */
    public function testStudentLoggingIn()
    {
        $user = User::where('username', 'student')->first();

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
        $user = User::where('username', 'student')->first();

        $data = [
            'email' => $user->email,
            'password' => 'wrong-password'
        ];

        $this->json('POST', route('login'), $data)
            ->assertStatus(JsonResponse::HTTP_UNAUTHORIZED)
            ->assertJson([
                'error' => 'Unauthorized'
            ]);
    }
}

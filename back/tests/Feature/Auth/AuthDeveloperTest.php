<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthDeveloperTest extends TestCase
{
    /**
     * @group developer
     */
    public function testDeveloperLoggingIn()
    {
        $user = User::where('username', 'developer')->first();

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
        $user = User::where('username', 'developer')->first();

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

<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthAdministratorTest extends TestCase
{
    /**
     * @group administrator
     */
    public function testAdministratorLoggingIn()
    {
        $user = User::where('username', 'administrator')->first();

        $data = [
            'email'     => $user->email,
            'password'  => 'azerty'
        ];

        $this->json('POST', route('login'), $data)
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure(['access_token']);
    }

    /**
     * @group administrator
     */
    public function testAdministratorLogginInWithWrongPassword()
    {
        $user = User::where('username', 'administrator')->first();

        $data = [
            'email'     => $user->email,
            'password'  => 'wrong-password'
        ];

        $this->json('POST', route('login'), $data)
            ->assertStatus(JsonResponse::HTTP_UNAUTHORIZED)
            ->assertJson([
                'error' => 'Unauthorized'
            ]);
    }
}

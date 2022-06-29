<?php

namespace Tests\Feature\Auth\Login;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class LoginAdministratorTest extends TestCase
{
    /**
     * @group administrator
     */

    public function testAdministratorLoggingIn()
    {
        $user = User::where('email', Role::ADMINISTRATOR . '@isep.fr')->first();

        $data = [
            'email'     => $user->email,
            'password'  => 'azertyuiop'
        ];
        $this->withoutExceptionHandling();

        $this->json('POST', route('login'), $data)
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure(['access_token']);
    }

    /**
     * @group administrator
     */
    public function testAdministratorLogginInWithWrongPassword()
    {
        $user = User::where('email', Role::ADMINISTRATOR . '@isep.fr')->first();

        $data = [
            'email'     => $user->email,
            'password'  => 'wrong-password'
        ];


        $this->json('POST', route('login'), $data)
            ->assertStatus(JsonResponse::HTTP_UNAUTHORIZED)
            ->assertJson(['errors' => ['login-form' => [trans('validation.login')]]]);
    }
}

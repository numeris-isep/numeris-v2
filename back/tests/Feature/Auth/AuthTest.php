<?php

namespace Tests\Feature\Auth;

use Illuminate\Http\JsonResponse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    /**
     * @group any
     */
    public function testAnyUserLoggingInWithoutFillingFields()
    {
        $this->json('POST', route('login'))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'email'     => ['Le champ email est obligatoire.'],
                    'password'  => ['Le champ mot de passe est obligatoire.']
                ]
            ]);
    }

    /**
     * @group any
     */
    public function testAnyUserLoggingInWithUnknownData()
    {
        $data = [
            'email'     => 'unknown@mail.com',
            'password'  => 'azerty'
        ];

        $this->json('POST', route('login'), $data)
            ->assertStatus(JsonResponse::HTTP_UNAUTHORIZED)
            ->assertJson([
                'error' => 'Unauthorized'
            ]);
    }
}

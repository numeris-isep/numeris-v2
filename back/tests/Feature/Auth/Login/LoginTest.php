<?php

namespace Tests\Feature\Auth\Login;

use Illuminate\Http\JsonResponse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    /**
     * @group any
     */
    public function testAnyUserLoggingInWithoutFillingFields()
    {
        $this->json('POST', route('login'))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['email', 'password']);
    }

    /**
     * @group any
     */
    public function testAnyUserLoggingInWithUnknownData()
    {
        $data = [
            'email'     => 'unknown@mail.com',
            'password'  => 'azertyuiop'
        ];
        $this->markTestSkipped('must be revisited.');

        $this->json('POST', route('login'), $data)
            ->assertStatus(JsonResponse::HTTP_UNAUTHORIZED)
            ->assertJson(['errors' => ['login' => [trans('validation.login')]]]);
    }
}

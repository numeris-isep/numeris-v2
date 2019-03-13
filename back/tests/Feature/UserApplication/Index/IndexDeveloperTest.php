<?php

namespace Tests\Feature\UserApplication\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperAccessingUserApplicationIndex()
    {
        $user_id = 1;

        $this->json('GET', route('users.applications.index', ['user_id' => $user_id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'userId',
                'userId',
                'type',
                'status',
                'createdAt',
                'updatedAt',
            ]]);
    }

    /**
     * @group developer
     */
    public function testDeveloperAccessingUnknownUserApplicationIndex()
    {
        $user_id = 0;

        $this->json('GET', route('users.applications.index', ['user_id' => $user_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson([
                'error' => trans('api.404')
            ]);
    }
}

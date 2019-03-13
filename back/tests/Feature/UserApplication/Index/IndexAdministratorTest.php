<?php

namespace Tests\Feature\UserApplication\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorAccessingUserApplicationIndex()
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
}

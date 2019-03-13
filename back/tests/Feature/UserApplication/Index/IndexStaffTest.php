<?php

namespace Tests\Feature\UserApplication\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffAccessingUserApplicationIndex()
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

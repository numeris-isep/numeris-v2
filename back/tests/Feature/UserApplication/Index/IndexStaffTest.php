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
        $user = auth()->user();

        $this->json('GET', route('users.applications.index', ['user_id' => $user->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'userId',
                'missionId',
                'type',
                'status',
                'createdAt',
                'updatedAt',
                'mission' => [
                    'address',
                    'project' => ['client']
                ],
            ]]);
    }
}

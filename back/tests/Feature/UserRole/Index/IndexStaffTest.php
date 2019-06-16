<?php

namespace Tests\Feature\UserRole\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStaffTest extends TestCaseWithAuth
{
    protected $username = Role::STAFF;

    /**
     * @group staff
     */
    public function testStaffAccessingRoleIndex()
    {
        $user = $this->activeStudentProvider();

        $this->json('GET', route('users.roles.index', ['user_id' => $user->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'name',
                'createdAt'
            ]]);
    }
}

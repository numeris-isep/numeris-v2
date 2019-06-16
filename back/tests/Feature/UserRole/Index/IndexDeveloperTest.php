<?php

namespace Tests\Feature\UserRole\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperAccessingRoleIndex()
    {
        $user = $this->activeStudentProvider();

        $this->json('GET', route('users.roles.index', ['user_id' => $user->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'name',
                'hierarchy',
                'createdAt'
            ]]);
    }
}

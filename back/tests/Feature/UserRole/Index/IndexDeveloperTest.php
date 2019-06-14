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
        $user_id = 1;

        $this->json('GET', route('users.roles.index', ['user_id' => $user_id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'name',
                'hierarchy',
                'createdAt'
            ]]);
    }
}

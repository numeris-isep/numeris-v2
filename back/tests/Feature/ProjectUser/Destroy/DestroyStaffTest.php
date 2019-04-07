<?php

namespace Tests\Feature\ProjectUser\Store;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffRemovingUserFromProject()
    {
        $project_id = 12; // private project
        $user_id = 1;

        $data = [
            'project_id'    => $project_id,
            'user_id'       => $user_id,
        ];

        $this->assertDatabaseHas('project_user', $data);

        $this->json('DELETE', route('projects.users.destroy', $data))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('project_user', $data);
    }
}

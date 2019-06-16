<?php

namespace Tests\Feature\ProjectUser\Store;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyStaffTest extends TestCaseWithAuth
{
    protected $username = Role::STAFF;

    /**
     * @group staff
     */
    public function testStaffRemovingUserFromProject()
    {
        $test_data = $this->privateProjectAndUserInProjectProvider();
        $project = $test_data['project'];
        $user = $test_data['user'];

        $data = [
            'project_id'    => $project->id,
            'user_id'       => $user->id,
        ];

        $this->assertDatabaseHas('project_user', $data);

        $this->json('DELETE', route('projects.users.destroy', $data))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('project_user', $data);
    }
}

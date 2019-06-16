<?php

namespace Tests\Feature\ProjectUser\Store;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentRemovingUserFromProject()
    {
        $test_data = $this->privateProjectAndUserInProjectProvider();
        $project = $test_data['project'];
        $user = $test_data['user'];

        $data = [
            'project_id'    => $project->id,
            'user_id'       => $user->id,
        ];

        $this->assertDatabaseHas('project_user', $data);

        $this->json('DELETE', route('projects.users.destroy', $data), ['user_id' => $user->id])
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertDatabaseHas('project_user', $data);
    }
}

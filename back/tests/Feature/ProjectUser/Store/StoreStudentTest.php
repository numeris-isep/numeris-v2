<?php

namespace Tests\Feature\ProjectUser\Store;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentAddingUserToProject()
    {
        $test_data = $this->privateProjectAndUserProvider();
        $project = $test_data['project'];
        $user = $test_data['user'];

        $data = [
            'project_id'    => $project->id,
            'user_id'       => $user->id,
        ];

        $this->assertDatabaseMissing('project_user', $data);

        $this->json(
            'POST',
            route('projects.users.store', ['project_id' => $project->id]),
            ['user_id' => $user->id])
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertDatabaseMissing('project_user', $data);
    }
}

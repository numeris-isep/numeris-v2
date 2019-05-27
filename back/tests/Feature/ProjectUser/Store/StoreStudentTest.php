<?php

namespace Tests\Feature\ProjectUser\Store;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentAddingUserToProject()
    {
        $project_id = 12; // private project
        $user_id = 2;

        $data = [
            'project_id'    => $project_id,
            'user_id'       => $user_id,
        ];

        $this->assertDatabaseMissing('project_user', $data);

        $this->json(
            'POST',
            route('projects.users.store', ['project_id' => $project_id]),
            ['user_id' => $user_id])
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertDatabaseMissing('project_user', $data);
    }
}

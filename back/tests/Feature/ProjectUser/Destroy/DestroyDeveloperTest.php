<?php

namespace Tests\Feature\ProjectUser\Store;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperRemovingUserFromProject()
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

    /**
     * @group developer
     */
    public function testDeveloperRemovingUserFromPublicProject()
    {
        $project_id = 1; // public project
        $user_id = 1;

        $data = [
            'project_id'    => $project_id,
            'user_id'       => $user_id,
        ];

        $this->assertDatabaseMissing('project_user', $data);

        $this->json('DELETE', route('projects.users.destroy', $data))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('api.404')]]);

        $this->assertDatabaseMissing('project_user', $data);
    }

    /**
     * @group developer
     */
    public function testDeveloperRemovingAlreadyRemovedUserFromProject()
    {
        $project_id = 12; // private project
        $user_id = 3; // already removed user

        $data = [
            'project_id'    => $project_id,
            'user_id'       => $user_id,
        ];

        $this->assertDatabaseMissing('project_user', $data);

        $this->json('DELETE', route('projects.users.destroy', $data))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertDatabaseMissing('project_user', $data);
    }
}

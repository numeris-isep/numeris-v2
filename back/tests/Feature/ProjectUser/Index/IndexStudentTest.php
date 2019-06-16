<?php

namespace Tests\Feature\ProjectUser\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;
use App\Models\Role;

class IndexStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group staff
     */
    public function testStudentAccessingProjectUserIndex()
    {
        $project = $this->privateProjectProvider();

        $this->json('GET', route('projects.users.index', ['project_id' => $project->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);
    }
}

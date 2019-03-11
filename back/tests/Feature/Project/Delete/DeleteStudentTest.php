<?php

namespace Tests\Feature\Project\Delete;

use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DeleteStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentDeletingProject()
    {
        $project_id = 1;
        $project = Project::find($project_id);

        $this->assertDatabaseHas('projects', $project->toArray());

        $this->json('DELETE', route('projects.destroy', ['project_id' => $project_id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);

        $this->assertDatabaseHas('projects', $project->toArray());
    }
}

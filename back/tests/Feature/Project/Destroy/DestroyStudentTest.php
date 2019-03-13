<?php

namespace Tests\Feature\Project\Destroy;

use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentDeletingProject()
    {
        $project_id = 1;
        $project = Project::find($project_id);
        $missions = $project->missions;

        $this->assertDatabaseHas('projects', $project->toArray());
        $this->assertDatabaseHas('missions', $missions->first()->toArray());

        $this->json('DELETE', route('projects.destroy', ['project_id' => $project_id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);

        $this->assertDatabaseHas('projects', $project->toArray());
        $this->assertDatabaseHas('missions', $missions->first()->toArray());
    }
}

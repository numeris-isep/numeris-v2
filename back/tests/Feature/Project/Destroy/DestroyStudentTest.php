<?php

namespace Tests\Feature\Project\Destroy;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentDeletingProject()
    {
        $test_data = $this->hiringProjectAndAvailableMissionProvider();
        $project = $test_data['project'];
        $mission = $test_data['mission'];

        $this->assertDatabaseHas('projects', $project->toArray());
        $this->assertDatabaseHas('missions', $mission->toArray());

        $this->json('DELETE', route('projects.destroy', ['project_id' => $project->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertDatabaseHas('projects', $project->toArray());
        $this->assertDatabaseHas('missions', $mission->toArray());
    }
}

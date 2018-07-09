<?php

namespace Tests\Feature\Project\Delete;

use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DeleteStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffDeletingProject()
    {
        $project_id = 1;
        $project = Project::find($project_id);

        $this->assertDatabaseHas('projects', $project->toArray());
        // TODO: check missions

        $this->json('DELETE', route('projects.destroy', ['project_id' => $project_id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('projects', $project->toArray());
        // TODO: check missions
    }
}

<?php

namespace Tests\Feature\Project\Delete;

use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DeleteAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorDeletingProject()
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

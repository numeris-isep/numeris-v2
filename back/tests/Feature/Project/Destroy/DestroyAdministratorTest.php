<?php

namespace Tests\Feature\Project\Destroy;

use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorDeletingProject()
    {
        $project_id = 1;
        $project = Project::find($project_id);
        $missions = $project->missions;

        $this->assertDatabaseHas('projects', $project->toArray());
        $this->assertDatabaseHas('missions', $missions->first()->toArray());

        $this->json('DELETE', route('projects.destroy', ['project_id' => $project_id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertDatabaseHas('projects', $project->toArray());
        $this->assertDatabaseHas('missions', $missions->first()->toArray());
    }
}

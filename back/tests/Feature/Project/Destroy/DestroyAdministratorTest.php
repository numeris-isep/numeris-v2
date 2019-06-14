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
     *
     * @dataProvider projectProvider
     */
    public function testAdministratorDeletingProjectWithoutBills($project)
    {
        $this->assertDatabaseHas('projects', $project->toArray());
        $this->assertTrue($project->missions->isEmpty());

        $this->json('DELETE', route('projects.destroy', ['project_id' => $project->id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('projects', $project->toArray());
    }

    /**
     * @group administrator
     *
     * @dataProvider clientAndProjectAndMissionAndConventionWithBillsProvider
     */
    public function testAdministratorDeletingProjectWithBills($client, $project, $mission, $convention)
    {
        $this->assertDatabaseHas('projects', $project->toArray());
        $this->assertDatabaseHas('missions', $mission->toArray());

        $this->json('DELETE', route('projects.destroy', ['project_id' => $project->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertDatabaseHas('projects', $project->toArray());
        $this->assertDatabaseHas('missions', $mission->toArray());
    }
}

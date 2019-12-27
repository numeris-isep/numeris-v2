<?php

namespace Tests\Feature\Project\Destroy;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorDeletingProjectWithoutBills()
    {
        $project = $this->projectProvider();

        $this->assertDatabaseHas('projects', $project->toArray());
        $this->assertTrue($project->missions->isEmpty());

        $this->json('DELETE', route('projects.destroy', ['project_id' => $project->id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('projects', $project->toArray());
    }

    /**
     * @group administrator
     */
    public function testAdministratorDeletingProjectWithBills()
    {
        $test_data = $this->clientAndProjectAndMissionAndConventionWithBillsProvider();
        $project = $test_data['project'];
        $mission = $test_data['mission'];

        unset($mission['reference']);

        $this->assertDatabaseHas('projects', $project->toArray());
        $this->assertDatabaseHas('missions', $mission->toArray());

        $this->json('DELETE', route('projects.destroy', ['project_id' => $project->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.roles.' . Role::ADMINISTRATOR)]]);

        $this->assertDatabaseHas('projects', $project->toArray());
        $this->assertDatabaseHas('missions', $mission->toArray());
    }
}

<?php

namespace Tests\Feature\Project\Update;

use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     *
     * @dataProvider conventionAndProjectProvider
     */
    public function testDeveloperUpdatingProject($convention, $project)
    {
        $data = [
            'client_id'     => $convention->client->id,
            'convention_id' => $convention->id,
            'name'          => 'Projet de test',
            'start_at'      => now()->toDateString(),
            'is_private'    => false,
        ];

        $this->assertDatabaseMissing('projects', $data);

        $this->json('PUT', route('projects.update', ['project_id' => $project->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'name',
                'step',
                'startAt',
                'isPrivate',
                'moneyReceivedAt',
                'createdAt',
                'updatedAt',
                'missionsCount',
                'usersCount',
            ]);

        $this->assertDatabaseHas('projects', $data);
    }

    /**
     * @group developer
     *
     * @dataProvider projectAndMissionWithBillsProvider
     */
    public function testDeveloperUpdatingProjectWithAlreadyUsedData($otherProject)
    {
        $project = factory(Project::class)->create();

        $data = [
            'client_id'     => $otherProject->client->id,
            'convention_id' => $otherProject->convention->id,
            'name'          => $otherProject->name,
            'start_at'      => now()->toDateString(),
            'is_private'    => false,
        ];

        $this->assertDatabaseMissing('projects', $data);

        $this->json('PUT', route('projects.update', ['project_id' => $project->id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);

        $this->assertDatabaseMissing('projects', $data);
    }

    /**
     * @group developer
     *
     * @dataProvider projectProvider
     */
    public function testDeveloperUpdatingProjectWithUnknownProjectData($project)
    {
        $data = [
            'client_id'     => 0,
            'convention_id' => 0,
            'name'          => 'Projet de test',
            'start_at'      => now()->toDateString(),
            'is_private'    => false,
        ];

        $this->assertDatabaseMissing('projects', $data);

        $this->json('PUT', route('projects.update', ['project_id' => $project->id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['client_id', 'convention_id']);

        $this->assertDatabaseMissing('projects', $data);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingProjectWithoutData()
    {
        $project_id = 1;

        $this->json('PUT', route('projects.update', ['project_id' => $project_id]))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['client_id', 'name', 'start_at']);
    }
}

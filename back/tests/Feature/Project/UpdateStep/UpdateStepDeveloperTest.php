<?php

namespace Tests\Feature\Project\UpdateStep;

use App\Models\Role;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateStepDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperUpdatingProjectStep()
    {
        $project = $this->projectProvider();

        $data = [
            'step' => Project::HIRING,
        ];

        $this->json('PATCH', route('projects.update.step', ['project_id' => $project->id]), $data)
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
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingProjectStepWithUnknownStep()
    {
        $project = $this->projectProvider();

        $data = [
            'step' => 'unknown-step',
        ];

        $this->json('PATCH', route('projects.update.step', ['project_id' => $project->id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['step']);
    }
}

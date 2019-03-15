<?php

namespace Tests\Feature\Project\Update;

use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateStepDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperUpdatingProjectStep()
    {
        $project_id = 1;

        $data = [
            'step' => Project::HIRING,
        ];

        $this->json('PATCH', route('projects.update.step', ['project_id' => $project_id]), $data)
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
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingProjectStepWithoutData()
    {
        $project_id = 1;

        $this->json('PATCH', route('projects.update.step', ['project_id' => $project_id]))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['step']);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingProjectStepWithUnknownStep()
    {
        $project_id = 1;

        $data = [
            'step' => 'unknown-step',
        ];

        $this->json('PATCH', route('projects.update.step', ['project_id' => $project_id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['step']);
    }
}

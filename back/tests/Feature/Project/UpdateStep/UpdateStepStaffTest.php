<?php

namespace Tests\Feature\Project\UpdateStep;

use App\Models\Role;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateStepStaffTest extends TestCaseWithAuth
{
    protected $username = Role::STAFF;

    /**
     * @group staff
     */
    public function testStaffUpdatingProjectStep()
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
}

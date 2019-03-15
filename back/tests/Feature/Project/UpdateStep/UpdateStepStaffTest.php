<?php

namespace Tests\Feature\Project\Update;

use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateStepStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffUpdatingProjectStep()
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
}

<?php

namespace Tests\Feature\Application\Update;

use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffUpdatingApplication()
    {
        $application_id = 1;

        $data = [
            'status' => Application::ACCEPTED,
        ];

        $this->json('PUT', route('applications.update', ['application_id' => $application_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'userId',
                'missionId',
                'type',
                'status',
                'createdAt',
                'updatedAt',
            ]);
    }
}

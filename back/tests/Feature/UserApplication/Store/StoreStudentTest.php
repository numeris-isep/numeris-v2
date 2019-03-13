<?php

namespace Tests\Feature\UserApplication\Store;

use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentCreatingApplication()
    {
        $user_id = 8;
        $mission_id = 40;

        $application = [
            'user_id'       => $user_id,
            'mission_id'    => $mission_id,
            'type'          => Application::USER_APPLICATION,
            'status'        => Application::WAITING
        ];
        $data = [
            'mission_id' => $mission_id,
        ];

        $this->assertDatabaseMissing('applications', $application);

        $this->json('POST', route('users.applications.store', ['user_id' => $user_id]), $data)
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

        $this->assertDatabaseHas('applications', $application);
    }
}

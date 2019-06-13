<?php

namespace Tests\Feature\MissionApplication\Store;

use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     *
     * @dataProvider availableMissionAndUserProvider
     */
    public function testStudentCreatingApplication($mission, $user)
    {
        $application = [
            'user_id'       => $user->id,
            'mission_id'    => $mission->id,
            'type'          => Application::STAFF_PLACEMENT,
            'status'        => Application::ACCEPTED
        ];
        $data = [
            'user_id' => $user->id,
        ];

        $this->assertDatabaseMissing('applications', $application);

        $this->json('POST', route('missions.applications.store', ['mission_id' => $mission->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertDatabaseMissing('applications', $application);
    }
}

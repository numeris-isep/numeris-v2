<?php

namespace Tests\Feature\MissionApplication\Store;

use App\Models\Application;
use App\Notifications\ApplicationNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;
use Tests\TestCaseWithAuth;
use App\Models\Role;

class StoreStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentCreatingApplication()
    {
        $test_data = $this->availableMissionAndUserProvider();
        $mission = $test_data['mission'];
        $user = $test_data['user'];

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
            ->assertJson(['errors' => [trans('errors.403')]]);

        $this->assertDatabaseMissing('applications', $application);

        Notification::assertNotSentTo($user, ApplicationNotification::class);
    }
}

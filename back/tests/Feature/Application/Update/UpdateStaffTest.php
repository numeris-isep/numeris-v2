<?php

namespace Tests\Feature\Application\Update;

use App\Mail\ApplicationMail;
use App\Models\Role;
use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Tests\TestCaseWithAuth;

class UpdateStaffTest extends TestCaseWithAuth
{
    protected $username = Role::STAFF;

    /**
     * @group staff
     */
    public function testStaffUpdatingApplication()
    {
        $mission = $this->hiringProjectAndAvailableMissionProvider()['mission'];
        $application = $this->applicationWithNoNotification($mission);

        $data = [
            'status' => Application::ACCEPTED,
        ];

        $this->json('PUT', route('applications.update', ['application_id' => $application->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'userId',
                'missionId',
                'type',
                'status',
                'createdAt',
                'updatedAt',
                'mission' => ['project'],
            ]);

        Mail::assertNotQueued(ApplicationMail::class);
    }
}

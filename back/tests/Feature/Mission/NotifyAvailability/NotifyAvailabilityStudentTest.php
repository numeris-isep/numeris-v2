<?php

namespace Tests\Feature\Mission\NotifyAvailability;

use App\Mail\NewMissionsAvailableMail;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Tests\TestCaseWithAuth;

class NotifyAvailabilityStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentNotifyingForNewMissions()
    {
        $mission = $this->availableMissionProvider();

        $data = ['missions' => [$mission->id]];

        $this->json('POST', route('missions.notify'), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);

        Mail::assertNotSent(NewMissionsAvailableMail::class);
    }
}

<?php

namespace Tests\Feature\Mission\NotifyAvailability;

use App\Mail\NewMissionsAvailableMail;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Tests\TestCaseWithAuth;

class NotifyAvailabilityStaffTest extends TestCaseWithAuth
{
    protected $username = Role::STAFF;

    /**
     * @group staff
     */
    public function testStaffNotifyingForNewMissions()
    {
        $mission = $this->availableMissionProvider();

        $data = ['missions' => [$mission->id]];

        $this->json('POST', route('missions.notify'), $data)
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        Mail::assertSent(NewMissionsAvailableMail::class);
    }
}

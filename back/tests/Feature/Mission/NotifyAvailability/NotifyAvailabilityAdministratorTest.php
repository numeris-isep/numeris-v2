<?php

namespace Tests\Feature\Mission\NotifyAvailability;

use App\Mail\NewMissionsAvailableMail;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Tests\TestCaseWithAuth;

class NotifyAvailabilityAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorNotifyingForNewMissions()
    {
        $mission = $this->availableMissionProvider();

        $data = ['missions' => [$mission->id]];

        $this->json('POST', route('missions.notify'), $data)
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        Mail::assertSent(NewMissionsAvailableMail::class);
    }
}

<?php

namespace Tests\Feature\Mission\NotifyAvailability;

use App\Mail\NewMissionsAvailableMail;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Tests\TestCaseWithAuth;

class NotifyAvailabilityDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperNotifyingForNewMissions()
    {
        $mission = $this->availableMissionProvider();

        $data = ['missions' => [$mission->id]];

        $this->json('POST', route('missions.notify'), $data)
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        Mail::assertSent(NewMissionsAvailableMail::class);
    }

    /**
     * @group developer
     */
    public function testDeveloperNotifyingForNewPrivateMissions()
    {
        $mission = $this->availablePrivateMissionAndUserProvider()['mission'];

        $data = ['missions' => [$mission->id]];

        $this->json('POST', route('missions.notify'), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['missions.0']);

        Mail::assertNotSent(NewMissionsAvailableMail::class);
    }

    /**
     * @group developer
     */
    public function testDeveloperNotifyingForNewMissionsWithoutMission()
    {
        $data = ['missions' => []];

        $this->json('POST', route('missions.notify'), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['missions']);

        Mail::assertNotSent(NewMissionsAvailableMail::class);
    }
}

<?php

namespace Tests\Feature\Mission\Show;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperAccessingMissionShow()
    {
        $mission = $this->availableMissionProvider();

        $this->json('GET', route('missions.show', ['mission_id' => $mission->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'id',
                'isLocked',
                'reference',
                'title',
                'description',
                'startAt',
                'duration',
                'capacity',
                'applicationsCount',
                'waitingApplicationsCount',
                'acceptedApplicationsCount',
                'refusedApplicationsCount',
                'project' => [
                    'client',
                    'convention',
                ],
                'user',
                'contact',
                'applications',
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperAccessingMissionShowWithUnknownMission()
    {
        $mission_id = 0; // Unknown mission

        $this->json('GET', route('missions.show', ['mission_id' => $mission_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('errors.404')]]);
    }
}

<?php

namespace Tests\Feature\Mission\Show;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     *
     * @dataProvider availableMissionProvider
     */
    public function testStaffAccessingMissionShow($mission)
    {
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
                'applications',
            ]);
    }
}

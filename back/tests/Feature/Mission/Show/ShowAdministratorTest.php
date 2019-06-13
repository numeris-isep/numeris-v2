<?php

namespace Tests\Feature\Mission\Show;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     *
     * @dataProvider availableMissionProvider
     */
    public function testAdministratorAccessingMissionShow($mission)
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

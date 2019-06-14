<?php

namespace Tests\Feature\ProjectMission\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     *
     * @dataProvider clientAndProjectAndMissionAndConventionWithBillsProvider
     */
    public function testAdministratorAccessingProjectMissionxIndex($client, $project, $mission, $convention)
    {
        $this->json('GET', route('projects.missions.index', ['project_id' => $project->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data' => [[
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
                    'project',
                ]],
                'links',
                'meta',
            ]);
    }
}

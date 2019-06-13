<?php

namespace Tests\Feature\ProjectMission\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     *
     * @dataProvider projectAndMissionWithBillsProvider
     */
    public function testStaffAccessingProjectMissionIndex($project, $mission)
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

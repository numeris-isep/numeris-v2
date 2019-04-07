<?php

namespace Tests\Feature\ProjectMission\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorAccessingProjectMissionxIndex()
    {
        $project_id = 1;

        $this->json('GET', route('projects.missions.index', ['project_id' => $project_id]))
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
                    'project',
                ]],
                'links',
                'meta',
            ]);
    }
}

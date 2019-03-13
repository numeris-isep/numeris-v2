<?php

namespace Tests\Feature\MissionApplication\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorAccessingMissionApplicationIndex()
    {
        $mission_id = 1;

        $this->json('GET', route('missions.applications.index', ['mission_id' => $mission_id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'userId',
                'missionId',
                'type',
                'status',
                'createdAt',
                'updatedAt',
            ]]);
    }
}

<?php

namespace Tests\Feature\MissionApplication\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffAccessingMissionApplicationIndex()
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

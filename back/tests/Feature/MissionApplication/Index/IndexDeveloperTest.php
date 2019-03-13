<?php

namespace Tests\Feature\MissionApplication\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperAccessingMissionApplicationIndex()
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

    /**
     * @group developer
     */
    public function testDeveloperAccessingUnknownMissionApplicationIndex()
    {
        $mission_id = 0;

        $this->json('GET', route('missions.applications.index', ['mission_id' => $mission_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson([
                'error' => trans('api.404')
            ]);
    }
}

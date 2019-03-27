<?php

namespace Tests\Feature\Mission\Show;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperAccessingMissionShow()
    {
        $mission_id = 1;

        $this->json('GET', route('missions.show', ['mission_id' => $mission_id]))
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
                'address',
                'project' => [
                    'client',
                ],
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
            ->assertJson([
                'error' => trans('api.404')
            ]);
    }
}

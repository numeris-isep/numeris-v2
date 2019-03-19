<?php

namespace Tests\Feature\Mission\Update;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateLockDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperUpdatingMissionLock()
    {
        $mission_id = 1;

        $data = [
            'is_locked' => true,
        ];

        $this->json('PATCH', route('missions.update.lock', ['mission_id' => $mission_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'isLocked',
                'title',
                'description',
                'startAt',
                'duration',
                'capacity',
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingMissionLockWithoutData()
    {
        $mission_id = 1;

        $this->json('PATCH', route('missions.update.lock', ['mission_id' => $mission_id]))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['is_locked']);
    }
}

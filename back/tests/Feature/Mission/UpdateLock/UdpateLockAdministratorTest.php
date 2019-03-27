<?php

namespace Tests\Feature\Mission\Update;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UdpateLockAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorUpdatingMissionLock()
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
                'reference',
                'title',
                'description',
                'startAt',
                'duration',
                'capacity',
            ]);
    }
}

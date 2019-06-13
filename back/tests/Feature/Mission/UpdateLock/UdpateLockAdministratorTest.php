<?php

namespace Tests\Feature\Mission\Update;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UdpateLockAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     *
     * @dataProvider availableMissionProvider
     */
    public function testAdministratorUpdatingMissionLock($mission)
    {
        $data = [
            'is_locked' => true,
        ];

        $this->json('PATCH', route('missions.update.lock', ['mission_id' => $mission->id]), $data)
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

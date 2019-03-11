<?php

namespace Tests\Feature\Mission\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffAccesingMissionIndex()
    {
        $this->json('GET', route('missions.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'title',
                'description',
                'startAt',
                'duration',
                'capacity',
                'address',
                'project',
            ]]);
    }
}

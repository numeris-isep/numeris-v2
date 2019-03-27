<?php

namespace Tests\Feature\Mission\IndexAvailable;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexAvailableStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffAccesingMissionIndex()
    {
        $this->json('GET', route('missions.index.available'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
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
                'applications'
            ]]);
    }
}

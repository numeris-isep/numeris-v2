<?php

namespace Tests\Feature\Mission\IndexAvailable;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexAvailableAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorAccesingMissionIndex()
    {
        $this->json('GET', route('missions.index.available'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'isLocked',
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

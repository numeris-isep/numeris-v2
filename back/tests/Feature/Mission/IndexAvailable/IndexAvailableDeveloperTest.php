<?php

namespace Tests\Feature\Mission\IndexAvailable;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexAvailableDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperAccessingMissionIndex()
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

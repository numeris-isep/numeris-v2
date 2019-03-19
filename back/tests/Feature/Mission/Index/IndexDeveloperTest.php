<?php

namespace Tests\Feature\Mission\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperAccessingMissionIndex()
    {
        $this->json('GET', route('missions.index'))
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
            ]]);
    }
}

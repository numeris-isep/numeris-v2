<?php

namespace Tests\Feature\Mission\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorAccesingMissionIndex()
    {
        $this->json('GET', route('missions.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'isLocked',
                    'reference',
                    'title',
                    'description',
                    'startAt',
                    'duration',
                    'capacity',
                    'applicationsCount',
                    'project',
                ]],
                'links',
                'meta',
            ]);
    }
}

<?php

namespace Tests\Feature\Project\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperAccessingProjectIndex()
    {
        $this->json('GET', route('projects.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'name',
                'step',
                'startAt',
                'isPrivate',
                'moneyReceivedAt',
                'createdAt',
                'updatedAt',
                'missionsCount',
                'usersCount',
            ]]);
    }

    /**
     * @group developer
     */
    public function testDeveloperAccessingPaginatedProjectIndex()
    {
        $this->json('GET', route('projects.index', ['page' => 1]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'name',
                    'step',
                    'startAt',
                    'isPrivate',
                    'moneyReceivedAt',
                    'createdAt',
                    'updatedAt',
                ]],
                'links',
                'meta',
            ]);
    }
}

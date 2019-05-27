<?php

namespace Tests\Feature\Application\IndexStatuses;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStatusesDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperAccessingApplicationStatusesIndex()
    {
        $this->json('GET', route('applications.statuses.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'status',
                'translation',
                'translationPlural',
            ]]);
    }
}

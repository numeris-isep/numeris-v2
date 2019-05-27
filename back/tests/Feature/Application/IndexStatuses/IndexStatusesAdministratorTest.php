<?php

namespace Tests\Feature\Application\IndexStatuses;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStatusesAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorAccessingApplicationStatusesIndex()
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

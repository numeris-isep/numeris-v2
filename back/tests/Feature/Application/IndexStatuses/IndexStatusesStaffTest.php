<?php

namespace Tests\Feature\Application\IndexStatuses;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStatusesStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffAccessingApplicationStatusesIndex()
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

<?php

namespace Tests\Feature\Application\IndexStatuses;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStatusesStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentAccessingApplicationStatusesIndex()
    {
        $this->json('GET', route('applications.statuses.index'))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);
    }
}

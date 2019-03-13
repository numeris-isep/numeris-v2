<?php

namespace Tests\Feature\MissionApplication\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentAccessingMissionApplicationIndex()
    {
        $mission_id = 1;

        $this->json('GET', route('missions.applications.index', ['mission_id' => $mission_id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);
    }
}

<?php

namespace Tests\Feature\Mission\Show;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentAccessingMissionShow()
    {
        $mission_id = 1;

        $this->json('GET', route('missions.show', ['mission_id' => $mission_id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);
    }
}

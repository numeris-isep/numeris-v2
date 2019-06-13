<?php

namespace Tests\Feature\Mission\Show;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     *
     * @dataProvider availableMissionProvider
     */
    public function testStudentAccessingMissionShow($mission)
    {
        $this->json('GET', route('missions.show', ['mission_id' => $mission->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);
    }
}

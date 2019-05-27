<?php

namespace Tests\Feature\ProjectMission\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentAccessingProjectMissionIndex()
    {
        $project_id = 1;

        $this->json('GET', route('projects.missions.index', ['project_id' => $project_id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);
    }
}

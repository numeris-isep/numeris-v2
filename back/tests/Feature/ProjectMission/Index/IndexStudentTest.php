<?php

namespace Tests\Feature\ProjectMission\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentAccessingProjectMissionIndex()
    {
        $project = $this->clientAndProjectAndMissionAndConventionWithBillsProvider()['project'];

        $this->json('GET', route('projects.missions.index', ['project_id' => $project->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);
    }
}

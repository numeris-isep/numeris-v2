<?php

namespace Tests\Feature\Project\Show;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentAccessingProjectShow()
    {
        $test_data = $this->clientAndProjectAndMissionAndConventionWithBillsProvider();
        $project = $test_data['project'];

        $this->json('GET', route('projects.show', ['project_id' => $project->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);
    }
}

<?php

namespace Tests\Feature\Project\Show;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     *
     * @dataProvider projectAndMissionWithBillsProvider
     */
    public function testStudentAccessingProjectShow($project)
    {
        $this->json('GET', route('projects.show', ['project_id' => $project->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);
    }
}

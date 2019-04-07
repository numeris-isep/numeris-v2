<?php

namespace Tests\Feature\ProjectUser\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group staff
     */
    public function testStaffAccessingProjectUserIndex()
    {
        $project_id = 12; // Private project

        $this->json('GET', route('projects.users.index', ['project_id' => $project_id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);
    }
}

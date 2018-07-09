<?php

namespace Tests\Feature\Project\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentAccesingProjectIndex()
    {
        $this->json('GET', route('projects.index'))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);
    }
}

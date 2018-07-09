<?php

namespace Tests\Feature\Project\Update;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentUpdatingProject()
    {
        $project_id = 1;

        $data = [
            'client_id'     => 1,
            'name'          => 'Projet de test',
            'start_at'      => now()->toDateString(),
            'is_private'    => false,
        ];

        $this->assertDatabaseMissing('projects', $data);

        $this->json('PUT', route('projects.update', ['project_id' => $project_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);

        $this->assertDatabaseMissing('projects', $data);
    }
}

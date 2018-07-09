<?php

namespace Tests\Feature\Project\Store;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentCreatingProject()
    {
        $data = [
            'client_id'     => 1,
            'name'          => 'Projet de test',
            'start_at'      => now()->toDateString(),
            'is_private'    => false,
        ];

        $this->assertDatabaseMissing('projects', $data);

        $this->json('POST', route('projects.store'), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);

        $this->assertDatabaseMissing('projects', $data);
    }
}

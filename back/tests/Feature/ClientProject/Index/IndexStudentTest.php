<?php

namespace Tests\Feature\ClientProject\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentAccessingClientProjectIndex()
    {
        $client = $this->clientWithProjectsWithMissionsProvider();

        $this->json('GET', route('clients.projects.index', ['client_id' => $client->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);
    }
}

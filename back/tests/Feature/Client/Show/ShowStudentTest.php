<?php

namespace Tests\Feature\Client\Show;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentAccessingClientShow()
    {
        $client = $this->clientWithProjectsWithMissionsProvider();

        $this->json('GET', route('clients.show', ['client_id' => $client->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);
    }
}

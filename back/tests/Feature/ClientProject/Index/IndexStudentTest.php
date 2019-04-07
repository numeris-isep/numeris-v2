<?php

namespace Tests\Feature\ClientProject\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentAccessingClientProjectIndex()
    {
        $client_id = 1;

        $this->json('GET', route('clients.projects.index', ['client_id' => $client_id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);
    }
}

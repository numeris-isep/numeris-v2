<?php

namespace Tests\Feature\ClientConvention\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentAccessingClientConventionIndex()
    {
        $client_id = 1;

        $this->json('GET', route('clients.conventions.index', ['client_id' => $client_id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);
    }
}

<?php

namespace Tests\Feature\ClientConvention\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorAccessingClientConventionIndex()
    {
        $client_id = 1;

        $this->json('GET', route('clients.conventions.index', ['client_id' => $client_id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'name',
                'createdAt',
                'updatedAt',
            ]]);
    }
}

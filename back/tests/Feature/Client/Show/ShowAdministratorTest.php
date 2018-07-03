<?php

namespace Tests\Feature\Client\Show;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorAccessingClientShow()
    {
        $client_id = 1;

        $this->json('GET', route('clients.show', ['client_id' => $client_id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'id',
                'address_id',
                'name',
                'reference',
                'created_at',
                'updated_at'
            ]);
    }
}

<?php

namespace Tests\Feature\ClientConvention\Store;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorCreatingConvention()
    {
        $client_id = 1;

        $data = [
            'name' => '11-1111',
        ];

        $this->assertDatabaseMissing('conventions', $data);

        $this->json('POST', route('clients.conventions.store', ['client_id' => $client_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'name',
            ]);

        $this->assertDatabaseHas('conventions', $data);
    }
}

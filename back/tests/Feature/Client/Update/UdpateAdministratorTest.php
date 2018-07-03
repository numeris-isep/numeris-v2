<?php

namespace Tests\Feature\Client\Update;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UdpateAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorUpdatingClient()
    {
        $client_id = 1;

        $data = [
            'name'      => 'AS Something',
            'reference' => '00-0000'
        ];

        $this->assertDatabaseMissing('clients', $data);

        $this->json('PUT', route('clients.update', ['client_id' => $client_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'address_id',
                'name',
                'reference',
                'created_at',
                'updated_at'
            ]);

        $this->assertDatabaseHas('clients', $data);
    }
}

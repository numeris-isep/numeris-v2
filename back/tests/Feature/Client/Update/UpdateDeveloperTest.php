<?php

namespace Tests\Feature\Client\Update;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperUpdatingClient()
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

    /**
     * @group developer
     */
    public function testDeveloperUpdatingClientWithAlreadyUsedData()
    {
        $client_id = 1;

        $data = [
            'name'      => 'AS Connect', // Already used
            'reference' => '01-0001' // Already used
        ];

        $this->assertDatabaseHas('clients', $data);

        $this->json('PUT', route('clients.update', ['client_id' => $client_id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'name'      => ['La valeur du champ nom est déjà utilisée.'],
                    'reference' => ['La valeur du champ reférence est déjà utilisée.'],
                ]
            ]);

        $this->assertDatabaseHas('clients', $data);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingUserWithoutData()
    {
        $client_id = 1;

        $this->json('PUT', route('clients.update', ['client_id' => $client_id]))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'name'      => ['Le champ nom est obligatoire.'],
                    'reference' => ['Le champ reférence est obligatoire.'],
                ]
            ]);
    }
}

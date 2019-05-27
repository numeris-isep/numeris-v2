<?php

namespace Tests\Feature\Client\Store;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperCreatingClient()
    {
        $client_data = [
            'name'      => 'AS Something',
            'reference' => '00-0000',
        ];
        $address_data = [
            'street'    => '1 rue Quelquepart',
            'zip_code'  => '75015',
            'city'      => 'Paris',
        ];
        $data = array_merge($client_data, ['address' => $address_data]);

        $this->assertDatabaseMissing('clients', $client_data);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('POST', route('clients.store'), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'addressId',
                'contactId',
                'name',
                'reference',
                'createdAt',
                'updatedAt',
                'conventionsCount',
                'projectsCount',
                'missionsCount',
            ]);

        $this->assertDatabaseHas('clients', $client_data);
        $this->assertDatabaseHas('addresses', $address_data);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingClientWithAlreadyUsedData()
    {
        $client_data = [
            'name'      => 'AS Connect', // Already used
            'reference' => '01-0001' // Already used
        ];
        $address_data = [
            'street'    => '1 rue Quelquepart',
            'zip_code'  => '75015',
            'city'      => 'Paris',
        ];
        $data = array_merge($client_data, ['address' => $address_data]);

        $this->assertDatabaseHas('clients', $client_data);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('POST', route('clients.store'), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name', 'reference']);

        $this->assertDatabaseHas('clients', $client_data);
        $this->assertDatabaseMissing('addresses', $address_data);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingClientWithoutData()
    {
        $this->json('POST', route('clients.store'))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'name',
                'reference',
                'address.street',
                'address.zip_code',
                'address.city',
            ]);
    }
}

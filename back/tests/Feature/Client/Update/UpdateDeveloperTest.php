<?php

namespace Tests\Feature\Client\Update;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperUpdatingClient()
    {
        $client = $this->clientProvider();

        $client_data = [
            'name'          => 'AS Something',
            'time_limit'    => 30,
        ];
        $address_data = [
            'street'    => '1 rue Quelquepart',
            'zip_code'  => '75015',
            'city'      => 'Paris',
        ];
        $data = array_merge($client_data, ['address' => $address_data]);

        $this->assertDatabaseMissing('clients', $client_data);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('PUT', route('clients.update', ['client_id' => $client->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'addressId',
                'contactId',
                'name',
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
    public function testDeveloperUpdatingClientWithWrongData()
    {
        $client = $this->clientProvider();

        $client_data = [
            'name'          => 'AS Connect', // Already used
            'time_limit'    => -1,
        ];
        $address_data = [
            'street'    => '1 rue Quelquepart',
            'zip_code'  => '75015',
            'city'      => 'Paris',
        ];
        $data = array_merge($client_data, ['address' => $address_data]);

        $this->assertDatabaseHas('clients', ['name' => $client_data['name']]);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('PUT', route('clients.update', ['client_id' => $client->id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name', 'time_limit']);

        $this->assertDatabaseHas('clients', ['name' => $client_data['name']]);
        $this->assertDatabaseMissing('addresses', $address_data);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingClientWithoutData()
    {
        $client = $this->clientProvider();

        $this->json('PUT', route('clients.update', ['client_id' => $client->id]))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'name',
                'time_limit',
                'address.street',
                'address.zip_code',
                'address.city',
            ]);
    }
}

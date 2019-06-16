<?php

namespace Tests\Feature\Client\Update;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UdpateAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorUpdatingClient()
    {
        $client = $this->clientProvider();

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

        $this->json('PUT', route('clients.update', ['client_id' => $client->id]), $data)
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
}

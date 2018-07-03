<?php

namespace Tests\Feature\Client\Delete;

use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DeleteStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffDeletingClient()
    {
        $client_id = 1;
        $client = Client::find($client_id);
        $address = $client->address;

        $this->assertDatabaseHas('clients', $client->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());

        $this->json('DELETE', route('clients.destroy', ['client_id' => $client_id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('clients', $client->toArray());
        $this->assertDatabaseMissing('addresses', $address->toArray());
    }
}

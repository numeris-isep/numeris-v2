<?php

namespace Tests\Feature\Client\Delete;

use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DeleteDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperDeletingClient()
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

    /**
     * @group developer
     */
    public function testDeveloperDeletingUnknownClient()
    {
        $client_id = 0; // Unknown client

        $this->json('DELETE', route('clients.destroy', ['client_id' => $client_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson([
                'error' => 'Resource not found'
            ]);
    }
}

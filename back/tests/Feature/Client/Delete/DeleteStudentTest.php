<?php

namespace Tests\Feature\Client\Delete;

use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DeleteStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentDeletingUser()
    {
        $client_id = 1;
        $client = Client::find($client_id);
        $address = $client->address;

        $this->assertDatabaseHas('clients', $client->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());

        $this->json('DELETE', route('clients.destroy', ['client_id' => $client_id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => 'Forbidden'
            ]);

        $this->assertDatabaseHas('clients', $client->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());
    }
}

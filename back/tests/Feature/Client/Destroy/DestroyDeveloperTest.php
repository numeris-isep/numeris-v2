<?php

namespace Tests\Feature\Client\Destroy;

use App\Models\Client;
use App\Models\Mission;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyDeveloperTest extends TestCaseWithAuth
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
        $conventions = $client->conventions;
        $mission_project_id = $client->missions->first()->project_id;

        $this->assertDatabaseHas('clients', $client->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());
        $this->assertDatabaseHas('conventions', $conventions->get(0)->toArray());
        $this->assertDatabaseHas('conventions', $conventions->get(1)->toArray());
        $this->assertNotEmpty(Project::where('client_id', $client_id)->get());
        $this->assertNotEmpty(Mission::where('project_id', $mission_project_id)->get());

        $this->json('DELETE', route('clients.destroy', ['client_id' => $client_id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('clients', $client->toArray());
        $this->assertDatabaseMissing('addresses', $address->toArray());
        $this->assertDatabaseMissing('conventions', $conventions->get(0)->toArray());
        $this->assertDatabaseMissing('conventions', $conventions->get(1)->toArray());
        $this->assertEmpty(Project::where('client_id', $client_id)->get());
        $this->assertEmpty(Mission::where('project_id', $mission_project_id)->get());
    }

    /**
     * @group developer
     */
    public function testDeveloperDeletingUnknownClient()
    {
        $client_id = 0; // Unknown client

        $this->json('DELETE', route('clients.destroy', ['client_id' => $client_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('api.404')]]);
    }
}

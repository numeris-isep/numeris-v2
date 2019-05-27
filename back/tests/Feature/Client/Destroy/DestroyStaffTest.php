<?php

namespace Tests\Feature\Client\Destroy;

use App\Models\Client;
use App\Models\Mission;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyStaffTest extends TestCaseWithAuth
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
        $conventions = $client->conventions;
        $mission_project_id = $client->missions->first()->project_id;

        $this->assertDatabaseHas('clients', $client->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());
        $this->assertDatabaseHas('conventions', $conventions->get(0)->toArray());
        $this->assertDatabaseHas('conventions', $conventions->get(1)->toArray());
        $this->assertNotEmpty(Project::where('client_id', $client_id)->get());
        $this->assertNotEmpty(Mission::where('project_id', $mission_project_id)->get());

        $this->json('DELETE', route('clients.destroy', ['client_id' => $client_id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertDatabaseHas('clients', $client->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());
        $this->assertDatabaseHas('conventions', $conventions->get(0)->toArray());
        $this->assertDatabaseHas('conventions', $conventions->get(1)->toArray());
        $this->assertNotEmpty(Project::where('client_id', $client_id)->get());
        $this->assertNotEmpty(Mission::where('project_id', $mission_project_id)->get());
    }
}

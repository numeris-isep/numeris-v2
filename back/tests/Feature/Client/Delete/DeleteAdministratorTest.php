<?php

namespace Tests\Feature\Client\Delete;

use App\Models\Client;
use App\Models\Mission;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DeleteAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorDeletingClient()
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
            ->assertJson([
                'error' => trans('api.403')
            ]);

        $this->assertDatabaseHas('clients', $client->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());
        $this->assertDatabaseHas('conventions', $conventions->get(0)->toArray());
        $this->assertDatabaseHas('conventions', $conventions->get(1)->toArray());
        $this->assertNotEmpty(Project::where('client_id', $client_id)->get());
        $this->assertNotEmpty(Mission::where('project_id', $mission_project_id)->get());
    }
}

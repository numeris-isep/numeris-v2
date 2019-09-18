<?php

namespace Tests\Feature\Client\Show;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperAccessingClientShow()
    {
        $client = $this->clientWithProjectsWithMissionsProvider();

        $this->json('GET', route('clients.show', ['client_id' => $client->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
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
                'address',
                'contact',
                'conventions' => [['rates']],
                'invoices',
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperAccessingClientShowWithUnknownClient()
    {
        $client_id = 0; // Unknown client

        $this->json('GET', route('clients.show', ['client_id' => $client_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
                ->assertJson(['errors' => [trans('api.404')]]);
    }
}

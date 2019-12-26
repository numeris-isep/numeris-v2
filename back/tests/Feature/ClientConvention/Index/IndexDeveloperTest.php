<?php

namespace Tests\Feature\ClientConvention\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperAccessingClientConventionIndex()
    {
        $client = $this->clientAndProjectAndMissionAndConventionWithBillsProvider()['client'];

        $this->json('GET', route('clients.conventions.index', ['client_id' => $client->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'name',
                'createdAt',
                'updatedAt',
            ]]);
    }

    /**
     * @group developer
     */
    public function testDeveloperAccessingUnknownClientConventionIndex()
    {
        $client_id = 0; // Unknown client

        $this->json('GET', route('clients.conventions.index', ['client_id' => $client_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('errors.404')]]);
    }
}

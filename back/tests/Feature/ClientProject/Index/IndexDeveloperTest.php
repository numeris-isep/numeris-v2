<?php

namespace Tests\Feature\ClientProject\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperAccessingClientProjectIndex()
    {
        $client = $this->clientWithProjectsWithMissionsProvider();

        $this->json('GET', route('clients.projects.index', ['client_id' => $client->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'name',
                    'step',
                    'startAt',
                    'isPrivate',
                    'moneyReceivedAt',
                    'createdAt',
                    'updatedAt',
                    'missionsCount',
                    'usersCount',
                    'client',
                ]],
                'links',
                'meta',
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperAccessingUnknownClientProjectIndex()
    {
        $client_id = 0;

        $this->json('GET', route('clients.projects.index', ['client_id' => $client_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('api.404')]]);
    }
}

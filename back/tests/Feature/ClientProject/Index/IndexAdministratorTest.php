<?php

namespace Tests\Feature\ClientProject\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorAccessingClientProjectIndex()
    {
        $client_id = 1;

        $this->json('GET', route('clients.projects.index', ['client_id' => $client_id]))
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
}

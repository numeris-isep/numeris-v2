<?php

namespace Tests\Feature\ClientConvention\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStaffTest extends TestCaseWithAuth
{
    protected $username = Role::STAFF;

    /**
     * @group staff
     */
    public function testStaffAccessingClientConventionIndex()
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
}

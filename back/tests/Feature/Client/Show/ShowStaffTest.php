<?php

namespace Tests\Feature\Client\Show;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     *
     * @dataProvider clientWithProjectsWithMissionsProvider
     */
    public function testStaffAccessingClientShow($client)
    {
        $this->json('GET', route('clients.show', ['client_id' => $client->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'id',
                'addressId',
                'contactId',
                'name',
                'reference',
                'createdAt',
                'updatedAt',
                'conventionsCount',
                'projectsCount',
                'missionsCount',
                'address',
                'contact',
                'conventions' => [['rates']],
            ]);
    }
}

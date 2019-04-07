<?php

namespace Tests\Feature\ClientProject\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffAccessingClientProjectIndex()
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
                    'client',
                ]],
                'links',
                'meta',
            ]);
    }
}

<?php

namespace Tests\Feature\Client\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffAccessingClientIndex()
    {
        $this->json('GET', route('clients.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
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
            ]]);

    }
}

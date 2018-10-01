<?php

namespace Tests\Feature\Client\Store;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffCreatingClient()
    {
        $data = [
            'name'      => 'AS Something',
            'reference' => '00-0000'
        ];

        $this->assertDatabaseMissing('clients', $data);

        $this->json('POST', route('clients.store'), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'addressId',
                'name',
                'reference',
                'createdAt',
                'updatedAt',
                'address',
            ]);

        $this->assertDatabaseHas('clients', $data);
    }
}

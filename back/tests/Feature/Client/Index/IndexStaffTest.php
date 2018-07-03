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
    public function testStaffAccesingClientIndex()
    {
        $this->json('GET', route('clients.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'address_id',
                'name',
                'reference',
                'created_at',
                'updated_at'
            ]]);
    }
}

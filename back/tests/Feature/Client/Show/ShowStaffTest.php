<?php

namespace Tests\Feature\Client\Show;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffAccessingClientShow()
    {
        $client_id = 1;

        $this->json('GET', route('clients.show', ['client_id' => $client_id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'id',
                'addressId',
                'name',
                'reference',
                'createdAt',
                'updatedAt',
                'address',
                'conventions' => [['rates']],
            ]);
    }
}

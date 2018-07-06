<?php

namespace Tests\Feature\Address\Store;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffCreatingAddress()
    {
        $data = [
            'street' => '69 rue Balard',
            'zip_code' => 75015,
            'city' => 'Paris',
        ];

        $this->assertDatabaseMissing('addresses', $data);

        $this->json('POST', route('addresses.store'), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);

        $this->assertDatabaseMissing('addresses', $data);
    }
}

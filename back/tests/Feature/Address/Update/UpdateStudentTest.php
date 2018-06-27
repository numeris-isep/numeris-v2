<?php

namespace Tests\Feature\Address\Update;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentUpdatingAddress()
    {
        $address_id = 1;
        $data = [
            'street' => '69 rue Balard',
            'zip_code' => 75015,
            'city' => 'Paris',
        ];

        $this->assertDatabaseMissing('addresses', $data);

        $this->json('PUT', route('addresses.update', ['address_id' => $address_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => 'Forbidden'
            ]);

        $this->assertDatabaseMissing('addresses', $data);
    }
}

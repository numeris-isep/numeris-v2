<?php

namespace Tests\Feature\Rate\Update;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffUpdatingRate()
    {
        $rate_id = 1;

        $data = [
            'name'          => 'Heures de test',
            'is_flat'       => false,
            'for_student'   => 10,
            'for_staff'     => 12,
            'for_client'    => 15,
        ];

        $this->assertDatabaseMissing('rates', $data);

        $this->json('PUT', route('rates.update', ['rate_id' => $rate_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'name',
                'isFlat',
                'forStudent',
                'forStaff',
                'forClient',
            ]);

        $this->assertDatabaseHas('rates', $data);
    }
}

<?php

namespace Tests\Feature\ConventionRate\Store;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffCreatingRate()
    {
        $convention_id = 1;

        $data = [
            'name'          => 'Heures de test',
            'is_flat'       => false,
            'for_student'   => 10,
            'for_staff'     => 12,
            'for_client'    => 15,
        ];

        $this->assertDatabaseMissing('rates', $data);

        $this->json('POST', route('conventions.rates.store', ['convention_id' => $convention_id]), $data)
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

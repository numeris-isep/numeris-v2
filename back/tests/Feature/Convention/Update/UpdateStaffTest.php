<?php

namespace Tests\Feature\Convention\Update;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffUpdatingConvention()
    {
        $convention_id = 1;

        $data = [
            'name' => '11-1111',
        ];

        $this->assertDatabaseMissing('conventions', $data);

        $this->json('PUT', route('conventions.update', ['convention_id' => $convention_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'name',
            ]);

        $this->assertDatabaseHas('conventions', $data);
    }
}

<?php

namespace Tests\Feature\Mission\Destroy;

use App\Models\Mission;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffDeletingMission()
    {
        $mission_id = 1;
        $mission = Mission::find($mission_id);
        $address = $mission->address;

        $this->assertDatabaseHas('missions', $mission->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());

        $this->json('DELETE', route('missions.destroy', ['mission_id' => $mission_id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('missions', $mission->toArray());
        $this->assertDatabaseMissing('addresses', $address->toArray());
    }
}

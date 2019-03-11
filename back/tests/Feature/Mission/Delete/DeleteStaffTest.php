<?php

namespace Tests\Feature\Mission\Delete;

use App\Models\Mission;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DeleteStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffDeletingMission()
    {
        $mission_id = 1;
        $mission = Mission::find($mission_id);

        $this->assertDatabaseHas('missions', $mission->toArray());

        $this->json('DELETE', route('missions.destroy', ['mission_id' => $mission_id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('missions', $mission->toArray());
    }
}

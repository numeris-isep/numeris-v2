<?php

namespace Tests\Feature\Mission\Delete;

use App\Models\Mission;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DeleteAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorDeletingMission()
    {
        $mission_id = 1;
        $mission = Mission::find($mission_id);

        $this->assertDatabaseHas('missions', $mission->toArray());
        // TODO: check missions

        $this->json('DELETE', route('missions.destroy', ['mission_id' => $mission_id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('missions', $mission->toArray());
        // TODO: check missions
    }
}

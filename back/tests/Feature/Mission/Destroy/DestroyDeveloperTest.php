<?php

namespace Tests\Feature\Mission\Destroy;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperDeletingMissionWithoutBills()
    {
        $mission = $this->availableMissionProvider();
        unset($mission['reference']);

        $address = $mission->address;

        $this->assertDatabaseHas('missions', $mission->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());

        $this->json('DELETE', route('missions.destroy', ['mission_id' => $mission->id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('missions', $mission->toArray());
        $this->assertDatabaseMissing('addresses', $address->toArray());
    }

    /**
     * @group developer
     */
    public function testDeveloperDeletingMissionWithBills()
    {
        $mission = $this->clientAndProjectAndMissionAndConventionWithBillsProvider()['mission'];
        unset($mission['reference']);

        $address = $mission->address;

        $this->assertDatabaseHas('missions', $mission->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());

        $this->json('DELETE', route('missions.destroy', ['mission_id' => $mission->id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('missions', $mission->toArray());
        $this->assertDatabaseMissing('addresses', $address->toArray());
    }

    /**
     * @group developer
     */
    public function testDeveloperDeletingUnknownMission()
    {
        $mission_id = 0; // Unknown mission

        $this->json('DELETE', route('missions.destroy', ['mission_id' => $mission_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('errors.404')]]);
    }
}

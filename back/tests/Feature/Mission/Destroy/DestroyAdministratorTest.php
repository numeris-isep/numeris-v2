<?php

namespace Tests\Feature\Mission\Destroy;

use App\Models\Mission;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     *
     * @dataProvider availableMissionProvider
     */
    public function testAdministratorDeletingMission($mission)
    {
        $address = $mission->address;

        $this->assertDatabaseHas('missions', $mission->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());

        $this->json('DELETE', route('missions.destroy', ['mission_id' => $mission->id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('missions', $mission->toArray());
        $this->assertDatabaseMissing('addresses', $address->toArray());
    }
}

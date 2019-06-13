<?php

namespace Tests\Feature\Mission\Destroy;

use App\Models\Mission;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     *
     * @dataProvider availableMissionProvider
     */
    public function testStudentDeletingMission($mission)
    {
        $address = $mission->address;

        $this->assertDatabaseHas('missions', $mission->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());

        $this->json('DELETE', route('missions.destroy', ['mission_id' => $mission->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertDatabaseHas('missions', $mission->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());
    }
}

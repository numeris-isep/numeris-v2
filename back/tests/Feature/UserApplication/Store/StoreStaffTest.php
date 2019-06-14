<?php

namespace Tests\Feature\UserApplication\Store;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreStaffTest extends TestCaseWithAuth
{
    protected $username = Role::STAFF;

    /**
     * @group staff
     *
     * @dataProvider availableMissionProvider
     */
    public function testStaffCreatingApplication($mission)
    {
        $user = auth()->user();

        $data = ['mission_id' => $mission->id];
        $application = array_merge($data, ['user_id' => $user->id]);

        $this->assertDatabaseMissing('applications', $application);

        $this->json('POST', route('users.applications.store', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'userId',
                'missionId',
                'type',
                'status',
                'createdAt',
                'updatedAt',
            ]);

        $this->assertDatabaseHas('applications', $application);
    }
}

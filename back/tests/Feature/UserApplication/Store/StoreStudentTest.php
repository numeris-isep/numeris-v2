<?php

namespace Tests\Feature\UserApplication\Store;

use App\Models\Application;
use App\Models\Mission;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     *
     * @dataProvider availableMissionProvider
     */
    public function testStudentCreatingApplication($mission)
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

<?php

namespace Tests\Feature\UserApplication\Store;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentCreatingApplication()
    {
        $mission = $this->availableMissionProvider();
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

    /**
     * @group student
     */
    public function testStudentApplyingToAlreadyAppliedMission()
    {
        $application = $this->applicationWithAvailableMissionProvider();
        $user = auth()->user();

        $data = ['mission_id' => $application->mission->id];
        $application = array_merge($data, ['user_id' => $user->id]);

        $this->assertDatabaseHas('applications', $application);

        $this->json('POST', route('users.applications.store', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.roles.' . Role::STUDENT)]]);
    }

    /**
     * @group student
     */
    public function testStudentApplyingToLockedMission()
    {
        $mission = $this->lockedMissionAndUserProvider()['mission'];
        $user = auth()->user();

        $data = ['mission_id' => $mission->id];
        $application = array_merge($data, ['user_id' => $user->id]);

        $this->assertDatabaseMissing('applications', $application);

        $this->json('POST', route('users.applications.store', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.roles.' . Role::STUDENT)]]);

        $this->assertDatabaseMissing('applications', $application);
    }

    /**
     * @group student
     */
    public function testStudentApplyingToPastMission()
    {
        $mission = $this->pastMissionAndUserProvider()['mission'];
        $user = auth()->user();

        $data = ['mission_id' => $mission->id];
        $application = array_merge($data, ['user_id' => $user->id]);

        $this->assertDatabaseMissing('applications', $application);

        $this->json('POST', route('users.applications.store', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.roles.' . Role::STUDENT)]]);

        $this->assertDatabaseMissing('applications', $application);
    }
}

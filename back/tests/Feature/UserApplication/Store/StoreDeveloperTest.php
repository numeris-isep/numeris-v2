<?php

namespace Tests\Feature\UserApplication\Store;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperCreatingApplication()
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
     * @group developer
     */
    public function testDeveloperCreatingApplicationWithUnknownMission()
    {
        $user = auth()->user();
        $mission_id = 0;

        $data = ['mission_id' => $mission_id];
        $application = array_merge($data, ['user_id' => $user->id]);

        $this->assertDatabaseMissing('applications', $application);

        $this->json('POST', route('users.applications.store', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['mission_id']);

        $this->assertDatabaseMissing('applications', $application);

    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingApplicationWithoutData()
    {
        $user = auth()->user();

        $this->json('POST', route('users.applications.store', ['user_id' => $user->id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('errors.404')]]);
    }

    /**
     * @group developer
     */
    public function testDeveloperApplyingToAlreadyAppliedMission()
    {
        $application = $this->applicationWithAvailableMissionProvider();
        $user = auth()->user();

        $data = ['mission_id' => $application->mission->id];
        $application = array_merge($data, ['user_id' => $user->id]);

        $this->assertDatabaseHas('applications', $application);

        $this->json('POST', route('users.applications.store', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.application_exists')]]);
    }

    /**
     * @group developer
     */
    public function testDeveloperApplyingToLockedMission()
    {
        $mission = $this->lockedMissionAndUserProvider()['mission'];
        $user = auth()->user();

        $data = ['mission_id' => $mission->id];
        $application = array_merge($data, ['user_id' => $user->id]);

        $this->assertDatabaseMissing('applications', $application);

        $this->json('POST', route('users.applications.store', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.mission_locked')]]);

        $this->assertDatabaseMissing('applications', $application);
    }

    /**
     * @group developer
     */
    public function testDeveloperApplyingToPastMission()
    {
        $mission = $this->pastMissionAndUserProvider()['mission'];
        $user = auth()->user();

        $data = ['mission_id' => $mission->id];
        $application = array_merge($data, ['user_id' => $user->id]);

        $this->assertDatabaseMissing('applications', $application);

        $this->json('POST', route('users.applications.store', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.mission_expired')]]);

        $this->assertDatabaseMissing('applications', $application);
    }
}

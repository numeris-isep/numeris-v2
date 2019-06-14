<?php

namespace Tests\Feature\UserApplication\Store;
use App\Models\Application;
use App\Models\Mission;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     *
     * @dataProvider availableMissionProvider
     */
    public function testDeveloperCreatingApplication($mission)
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
            ->assertJson(['errors' => [trans('api.404')]]);
    }

    /**
     * @group developer
     *
     * @dataProvider applicationWithAvailableMissionProvider
     */
    public function testDeveloperApplyingToAlreadyAppliedMission($application)
    {
        $user = auth()->user();

        $data = ['mission_id' => $application->mission->id];
        $application = array_merge($data, ['user_id' => $user->id]);

        $this->assertDatabaseHas('applications', $application);

        $this->json('POST', route('users.applications.store', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['mission_id']);
    }

    /**
     * @group developer
     *
     * @dataProvider lockedMissionAndUserProvider
     */
    public function testDeveloperApplyingToLockedMission($mission)
    {
        $user = auth()->user();

        $data = ['mission_id' => $mission->id];
        $application = array_merge($data, ['user_id' => $user->id]);

        $this->assertDatabaseMissing('applications', $application);

        $this->json('POST', route('users.applications.store', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertDatabaseMissing('applications', $application);
    }

    /**
     * @group developer
     *
     * @dataProvider pastMissionAndUserProvider
     */
    public function testDeveloperApplyingToPastMission($mission)
    {
        $user = auth()->user();

        $data = ['mission_id' => $mission->id];
        $application = array_merge($data, ['user_id' => $user->id]);

        $this->assertDatabaseMissing('applications', $application);

        $this->json('POST', route('users.applications.store', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertDatabaseMissing('applications', $application);
    }
}

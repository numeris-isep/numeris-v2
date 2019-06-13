<?php

namespace Tests\Feature\MissionApplication\Store;
use App\Models\Application;
use App\Models\Mission;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     *
     * @dataProvider availableMissionAndUserProvider
     */
    public function testDeveloperCreatingApplication($mission, $user)
    {
        $application = [
            'user_id'       => $user->id,
            'mission_id'    => $mission->id,
            'type'          => Application::STAFF_PLACEMENT,
            'status'        => Application::ACCEPTED
        ];
        $data = [
            'user_id' => $user->id,
        ];

        $this->assertDatabaseMissing('applications', $application);

        $this->json('POST', route('missions.applications.store', ['mission_id' => $mission->id]), $data)
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
     *
     * @dataProvider availableMissionProvider
     */
    public function testDeveloperCreatingApplicationWithUnknownUser($mission)
    {
        $user_id = 0; // Unknown user

        $application = [
            'user_id'       => $user_id,
            'mission_id'    => $mission->id,
            'type'          => Application::STAFF_PLACEMENT,
            'status'        => Application::ACCEPTED,
        ];
        $data = [
            'user_id' => $user_id,
        ];

        $this->assertDatabaseMissing('applications', $application);

        $this->json('POST', route('missions.applications.store', ['mission_id' => $mission->id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['user_id']);

        $this->assertDatabaseMissing('applications', $application);
    }

    /**
     * @group developer
     *
     * @dataProvider userProvider
     */
    public function testDeveloperCreatingApplicationWithUnknownMission($user)
    {
        $mission_id = 0; // Unknown mission

        $application = [
            'user_id'       => $user->id,
            'mission_id'    => $mission_id,
            'type'          => Application::STAFF_PLACEMENT,
            'status'        => Application::ACCEPTED,
        ];
        $data = [
            'user_id' => $user->id,
        ];

        $this->assertDatabaseMissing('applications', $application);

        $this->json('POST', route('missions.applications.store', ['mission_id' => $mission_id]), $data)
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('api.404')]]);

        $this->assertDatabaseMissing('applications', $application);
    }

    /**
     * @group developer
     *
     * @dataProvider availableMissionProvider
     */
    public function testDeveloperCreatingApplicationWithoutData($mission)
    {
        $this->json('POST', route('missions.applications.store', ['mission_id' => $mission->id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('api.404')]]);
    }

    /**
     * @group developer
     *
     * @dataProvider availableMissionAndUserWhoAlreadyAppliedProviderProvider
     */
    public function testDeveloperCreatingApplicationToAlreadyAppliedMission($mission, $user)
    {
        $data = [
            'user_id' => $user->id,
        ];

        $this->json('POST', route('missions.applications.store', ['mission_id' => $mission->id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['user_id']);
    }

    /**
     * @group developer
     *
     * @dataProvider lockedMissionAndUserProvider
     */
    public function testDeveloperCreatingApplicationToLockedMission($mission, $user)
    {
        $application = [
            'user_id'       => $user->id,
            'mission_id'    => $mission->id,
            'type'          => Application::STAFF_PLACEMENT,
            'status'        => Application::WAITING
        ];
        $data = [
            'user_id' => $user->id,
        ];

        $this->assertDatabaseMissing('applications', $application);

        $this->json('POST', route('missions.applications.store', ['mission_id' => $mission->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertDatabaseMissing('applications', $application);
    }

    /**
     * @group developer
     *
     * @dataProvider pastMissionAndUserProvider
     */
    public function testDeveloperCreatingApplicationToPastMission($mission, $user)
    {
        $application = [
            'user_id'       => $user->id,
            'mission_id'    => $mission->id,
            'type'          => Application::STAFF_PLACEMENT,
            'status'        => Application::WAITING
        ];
        $data = [
            'user_id' => $user->id,
        ];

        $this->assertDatabaseMissing('applications', $application);

        $this->json('POST', route('missions.applications.store', ['mission_id' => $mission->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertDatabaseMissing('applications', $application);
    }

    /**
     * @group developer
     *
     * @dataProvider availablePrivateMissionAndUserProvider
     */
    public function testDeveloperApplyingUserToAvailablePrivateMission($mission, $user)
    {
        $application = [
            'user_id'       => $user->id,
            'mission_id'    => $mission->id,
            'type'          => Application::USER_APPLICATION,
            'status'        => Application::WAITING
        ];
        $data = [
            'user_id' => $user->id,
        ];

        $this->assertDatabaseMissing('applications', $application);

        $this->json('POST', route('missions.applications.store', ['mission_id' => $mission->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertDatabaseMissing('applications', $application);
    }

    /**
     * @group developer
     *
     * @dataProvider availablePrivateMissionAndUserInPrivateProjectProvider
     */
    public function testDeveloperApplyingUserInPrivateProjectToAvailablePrivateMission($mission, $user)
    {
        $application = [
            'user_id'       => $user->id,
            'mission_id'    => $mission->id,
            'type'          => Application::USER_APPLICATION,
            'status'        => Application::WAITING
        ];
        $data = [
            'user_id' => $user->id,
        ];

        $this->assertDatabaseMissing('applications', $application);

        $this->json('POST', route('missions.applications.store', ['mission_id' => $mission->id]), $data)
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

        $this->assertDatabaseMissing('applications', $application);
    }
}

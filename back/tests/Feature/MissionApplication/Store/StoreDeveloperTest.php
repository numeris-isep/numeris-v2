<?php

namespace Tests\Feature\MissionApplication\Store;

use App\Mail\ApplicationMail;
use App\Models\Role;
use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Tests\TestCaseWithAuth;

class StoreDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperCreatingApplication()
    {
        $test_data = $this->availableMissionAndUserProvider();
        $mission = $test_data['mission'];
        $user = $test_data['user'];

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

        Mail::assertNotQueued(ApplicationMail::class);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingApplicationWithAllNotifications()
    {
        $mission = $this->availableMissionProvider();
        $user = $this->userProvider();

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

        Mail::assertQueued(ApplicationMail::class, function (ApplicationMail $mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingApplicationWithUnknownUser()
    {
        $mission = $this->availableMissionProvider();

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

        Mail::assertNotQueued(ApplicationMail::class);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingApplicationWithUnknownMission()
    {
        $user = $this->userProvider();

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

        Mail::assertNotQueued(ApplicationMail::class);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingApplicationWithoutData()
    {
        $mission = $this->availableMissionProvider();

        $this->json('POST', route('missions.applications.store', ['mission_id' => $mission->id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('api.404')]]);

        Mail::assertNotQueued(ApplicationMail::class);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingApplicationToAlreadyAppliedMission()
    {
        $test_data = $this->availableMissionAndUserWhoAlreadyAppliedProviderProvider();
        $mission = $test_data['mission'];
        $user = $test_data['user'];

        $data = [
            'user_id' => $user->id,
        ];

        $this->json('POST', route('missions.applications.store', ['mission_id' => $mission->id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['user_id']);

        Mail::assertNotQueued(ApplicationMail::class);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingApplicationToLockedMission()
    {
        $test_data = $this->lockedMissionAndUserProvider();
        $mission = $test_data['mission'];
        $user = $test_data['user'];

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

        Mail::assertNotQueued(ApplicationMail::class);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingApplicationToPastMission()
    {
        $test_data = $this->pastMissionAndUserProvider();
        $mission = $test_data['mission'];
        $user = $test_data['user'];

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

        Mail::assertNotQueued(ApplicationMail::class);
    }

    /**
     * @group developer
     */
    public function testDeveloperApplyingUserToAvailablePrivateMission()
    {
        $test_data = $this->availablePrivateMissionAndUserProvider();
        $mission = $test_data['mission'];
        $user = $test_data['user'];

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

        Mail::assertNotQueued(ApplicationMail::class);
    }

    /**
     * @group developer
     */
    public function testDeveloperApplyingUserInPrivateProjectToAvailablePrivateMission()
    {
        $test_data = $this->availablePrivateMissionAndUserInPrivateProjectProvider();
        $mission = $test_data['mission'];
        $user = $test_data['user'];

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

        Mail::assertQueued(ApplicationMail::class, function (ApplicationMail $mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }
}

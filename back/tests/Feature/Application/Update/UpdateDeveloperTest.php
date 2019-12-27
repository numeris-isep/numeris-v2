<?php

namespace Tests\Feature\Application\Update;

use App\Models\Role;
use App\Models\Application;
use App\Notifications\ApplicationNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;
use Tests\TestCaseWithAuth;

class UpdateDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperUpdatingApplication()
    {
        $mission = $this->hiringProjectAndAvailableMissionProvider()['mission'];
        $application = $this->applicationWithNoNotification($mission);

        $data = [
            'status' => Application::ACCEPTED,
        ];

        $this->json('PUT', route('applications.update', ['application_id' => $application->id]), $data)
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

        Notification::assertNotSentTo($application->user, ApplicationNotification::class);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingApplicationToAcceptedWithNotification()
    {
        $mission = $this->hiringProjectAndAvailableMissionProvider()['mission'];
        $application = $this->applicationWithAllNotifications($mission);

        $data = [
            'status' => Application::ACCEPTED,
        ];

        $this->json('PUT', route('applications.update', ['application_id' => $application->id]), $data)
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

        Notification::assertSentTo($application->user, ApplicationNotification::class);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingApplicationToRefusedWithNotification()
    {
        $mission = $this->hiringProjectAndAvailableMissionProvider()['mission'];
        $application = $this->applicationWithAllNotifications($mission);

        $data = [
            'status' => Application::REFUSED,
        ];

        $this->json('PUT', route('applications.update', ['application_id' => $application->id]), $data)
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

        Notification::assertSentTo($application->user, ApplicationNotification::class);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingApplicationToWaitingWithNotification()
    {
        $mission = $this->hiringProjectAndAvailableMissionProvider()['mission'];
        $application = $this->applicationWithAllNotifications($mission);

        $data = [
            'status' => Application::WAITING,
        ];

        $this->json('PUT', route('applications.update', ['application_id' => $application->id]), $data)
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

        Notification::assertNotSentTo($application->user, ApplicationNotification::class);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingUnknownApplication()
    {
        $application_id = 0; // Unknown application

        $data = [
            'status' => Application::ACCEPTED,
        ];

        $this->json('PUT', route('applications.update', ['application_id' => $application_id]), $data)
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('errors.404')]]);

        Notification::assertNothingSent();
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingApplicationWhoseProjectIsNotHiring()
    {
        $mission = $this->validatedProjectAndAvailableMissionProvider()['mission'];

        $application = factory(Application::class)->create(['mission_id' => $mission->id]);

        $data = [
            'status' => Application::ACCEPTED,
        ];

        $this->json('PUT', route('applications.update', ['application_id' => $application->id]), $data)
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

        Notification::assertSentTo($application->user, ApplicationNotification::class);
    }
}

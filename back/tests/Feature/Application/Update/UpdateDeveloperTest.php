<?php

namespace Tests\Feature\Application\Update;

use App\Mail\ApplicationMail;
use App\Models\Role;
use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
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
                'mission' => ['project'],
            ]);

        Mail::assertNotQueued(ApplicationMail::class);
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
                'mission' => ['project'],
            ]);

        Mail::assertQueued(ApplicationMail::class, function ($mail) use ($application) {
            return $mail->hasTo($application->user->email);
        });
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
                'mission' => ['project'],
            ]);

        Mail::assertQueued(ApplicationMail::class, function (ApplicationMail $mail) use ($application) {
            return $mail->hasTo($application->user->email);
        });
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
                'mission' => ['project'],
            ]);

        Mail::assertNotQueued(ApplicationMail::class);
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
            ->assertJson(['errors' => [trans('api.404')]]);

        Mail::assertNotQueued(ApplicationMail::class);
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
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        Mail::assertNotQueued(ApplicationMail::class);
    }
}

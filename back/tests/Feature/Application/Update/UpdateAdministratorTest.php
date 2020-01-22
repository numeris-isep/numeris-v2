<?php

namespace Tests\Feature\Application\Update;

use App\Mail\ApplicationMail;
use App\Models\Project;
use App\Models\Role;
use App\Models\Application;
use App\Notifications\ApplicationNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCaseWithAuth;

class UpdateAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorUpdatingApplication()
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


        Notification::assertNotSentTo($application->user, ApplicationNotification::class);
    }

    /**
     * @group administrator
     */
    public function testAdministratorUpdatingApplicationWhoseProjectIsNotHiringOrValidated()
    {
        $mission = $this->validatedProjectAndAvailableMissionProvider()['mission'];

        $application = factory(Application::class)->create(['mission_id' => $mission->id]);

        $data = [
            'status' => Application::ACCEPTED,
        ];

        $this->json('PUT', route('applications.update', ['application_id' => $application->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans_choice('errors.wrong_project_step', 1, ['step' => 'Ouvert'])]]);

        Notification::assertNotSentTo($application->user, ApplicationNotification::class);
    }
}

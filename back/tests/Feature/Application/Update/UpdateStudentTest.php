<?php

namespace Tests\Feature\Application\Update;

use App\Mail\ApplicationMail;
use App\Models\Application;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Tests\TestCaseWithAuth;

class UpdateUpdateStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentUpdatingApplication()
    {
        $mission = $this->hiringProjectAndAvailableMissionProvider()['mission'];
        $application = $this->applicationWithNoNotification($mission);

        $data = [
            'status' => Application::ACCEPTED,
        ];

        $this->json('PUT', route('applications.update', ['application_id' => $application->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        Mail::assertNotQueued(ApplicationMail::class);
    }
}

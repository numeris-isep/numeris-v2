<?php

namespace Tests\Feature\Mission\SendEmail;

use App\Models\Role;
use App\Notifications\PreMissionNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;
use Tests\TestCaseWithAuth;

class SendEmailStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentSendingPreMissionEmail()
    {
        $data = [
            'subject' => 'Sujet du mail',
            'content' => '<h1 style="color: red;">Contenu du mail</h1>'
        ];
        $application = $this->applicationWithNoNotification();

        $this->json('POST', route('missions.email', ['mission_id' => $application->mission->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        Notification::assertNotSentTo($application->mission, PreMissionNotification::class);
    }
}

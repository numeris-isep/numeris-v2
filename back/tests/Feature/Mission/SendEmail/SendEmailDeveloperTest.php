<?php

namespace Tests\Feature\Mission\SendEmail;

use App\Models\Role;
use App\Notifications\PreMissionNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;
use Tests\TestCaseWithAuth;

class SendEmailDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperSendingPreMissionEmail()
    {
        $data = [
            'subject' => 'Sujet du mail',
            'content' => '<h1 style="color: red;">Contenu du mail</h1>'
        ];
        $application = $this->applicationWithNoNotification();

        $this->json('POST', route('missions.email', ['mission_id' => $application->mission->id]), $data)
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        Notification::assertSentTo($application->mission, PreMissionNotification::class);
    }

    /**
     * @group developer
     */
    public function testDeveloperSendingPreMissionEmailWithoutData()
    {
        $application = $this->applicationWithNoNotification();

        $this->json('POST', route('missions.email', ['mission_id' => $application->mission->id]))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['subject', 'content']);
    }
}

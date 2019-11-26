<?php

namespace Tests\Feature\Mission\SendEmail;

use App\Models\Role;
use App\Notifications\PreMissionNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;
use Tests\TestCaseWithAuth;

class SendEmailStaffTest extends TestCaseWithAuth
{
    protected $username = Role::STAFF;

    /**
     * @group staff
     */
    public function testStaffSendingPreMissionEmail()
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
}

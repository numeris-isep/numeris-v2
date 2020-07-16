<?php

namespace Tests\Feature\Message\Update;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;
use App\Models\Message;

class UpdateActivatedStaffTest extends TestCaseWithAuth
{
    protected $username = Role::STAFF;

    /**
     * @group message
     */
    public function testStaffUpdatingActivatedMessage()
    {
        $message = $this->messageProvider();

        $active = [
            'is_active' => true,
        ];

        $this->json('PATCH', route('messages.updateActivated', ['message_id' => $message->id]), $active)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);

        $this->assertFalse($message['is_active']);
    }

    /**
     * @group message
     */
    public function testStaffStudentUpdatingDeactivatedMessage()
    {
        $message_inactive = $this->messageProvider();
        $this->assertFalse($message_inactive['is_active']);

        $message = $this->messageProvider();
        $this->assertFalse($message['is_active']);

        $inactive = [
            'is_active' => false,
        ];

        $response = $this->json('PATCH', route('messages.updateActivated', ['message_id' => $message->id]), $inactive)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);

        $message = Message::find($message->id);
        $message_inactive = Message::find($message_inactive->id);

        $this->assertFalse($message_inactive['is_active']);
        $this->assertFalse($message['is_active']);
    }
}

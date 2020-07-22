<?php

namespace Tests\Feature\Message\Update;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;
use App\Models\Message;

class UpdateActivatedAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group message
     */
    public function testAdministratorUpdatingActivatedMessage()
    {
        $message_active = $this->messageActiveProvider();
        $this->assertTrue($message_active['is_active']);

        $message = $this->messageProvider();
        $this->assertFalse($message['is_active']);

        $active = [
            'is_active' => true,
        ];

        $response = $this->json('PATCH', route('messages.updateActivated', ['message_id' => $message->id]), $active)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'title',
                'content',
                'link',
                'is_active',
                'created_at',
                'updated_at',
                'deleted_at',
            ]);

        $message = Message::find($message->id);
        $message_active = Message::find($message_active->id);

        $this->assertFalse($message_active['is_active']);
        $this->assertTrue($message['is_active']);
    }

    /**
     * @group message
     */
    public function testAdministratorDeveloperUpdatingDeactivatedMessage()
    {
        $message_inactive = $this->messageProvider();
        $this->assertFalse($message_inactive['is_active']);

        $message = $this->messageProvider();
        $this->assertFalse($message['is_active']);

        $inactive = [
            'is_active' => false,
        ];

        $response = $this->json('PATCH', route('messages.updateActivated', ['message_id' => $message->id]), $inactive)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'title',
                'content',
                'link',
                'is_active',
                'created_at',
                'updated_at',
                'deleted_at',
            ]);

        $message = Message::find($message->id);
        $message_inactive = Message::find($message_inactive->id);

        $this->assertFalse($message_inactive['is_active']);
        $this->assertFalse($message['is_active']);
    }
}

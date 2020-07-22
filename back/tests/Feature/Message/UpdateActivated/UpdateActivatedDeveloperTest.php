<?php

namespace Tests\Feature\Message\Update;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;
use App\Models\Message;

class UpdateActivatedDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group message
     */
    public function testDeveloperUpdatingActivatedMessage()
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
}

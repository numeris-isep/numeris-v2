<?php

namespace Tests\Feature\Message\Update;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateActivatedStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group message
     */
    public function testStudentUpdatingActivatedMessage()
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
}

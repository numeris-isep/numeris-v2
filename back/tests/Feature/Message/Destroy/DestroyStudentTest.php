<?php

namespace Tests\Feature\Message\Destroy;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group message
     */
    public function testStudentDeletingMessage()
    {
        $message = $this->messageProvider();

        $this->assertDatabaseHas('messages', $message->toArray());

        $this->json('DELETE', route('messages.destroy', ['message_id' => $message->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);

        $this->assertDatabaseHas('messages', $message->toArray());
    }
}
